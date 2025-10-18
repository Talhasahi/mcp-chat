<?php
// mcp-tools.php
?>

<button class="tool-btn"><i class="fas fa-tools attachment" onclick="toggleToolsDropdown()"></i></button>
<style>
    .tools-dropdown {
        position: absolute;
        bottom: 100%;
        /* Position above the icon */
        left: 0;
        background-color: #FFFFFF;
        border: 1px solid #E4E4E7;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        min-width: 250px;
        z-index: 1000;
        display: none;
        padding: 10px 0;
        overflow: hidden;
        /* For smooth sub expansion */
    }

    .tools-dropdown.active {
        display: block;
    }

    .tools-item {
        display: flex;
        align-items: center;
        padding: 12px 20px;
        cursor: pointer;
        transition: background-color 0.2s ease;
        font-size: 14px;
        color: #000000;
        border-bottom: 1px solid #F0F0F0;
        position: relative;
        overflow: hidden;
    }

    .tools-item:last-child {
        border-bottom: none;
    }

    .tools-item:hover {
        background-color: #F0F0F0;
    }

    .tools-item i {
        margin-right: 10px;
        width: 16px;
        color: #00B7E5;
    }

    /* Sub-dropdown styles - vertical below parent with animation */
    .sub-tools-dropdown {
        background-color: #FFFFFF;
        border: 1px solid #E4E4E7;
        border-top: none;
        /* Seamless connection */
        border-radius: 0 0 10px 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        width: 100%;
        max-height: 0;
        /* Start collapsed */
        overflow: hidden;
        z-index: 1001;
        transition: max-height 0.3s ease-out, opacity 0.3s ease-out;
        opacity: 0;
        padding: 0;
    }

    .sub-tools-dropdown.active {
        max-height: 300px;
        /* Expand to max needed height */
        opacity: 1;
        padding: 0 0 10px 0;
        /* Add bottom padding when open */
    }

    .sub-tools-item {
        padding: 8px 20px;
        /* Reduced padding for less space */
        cursor: pointer;
        transition: background-color 0.2s ease;
        font-size: 13px;
        color: #333333;
        border-bottom: 1px solid #F8F8F8;
        line-height: 1.3;
    }

    .sub-tools-item:last-child {
        border-bottom: none;
    }

    .sub-tools-item:hover {
        background-color: #F8F8F8;
    }

    .tools-item.has-sub::after {
        content: '▾';
        position: absolute;
        right: 15px;
        font-size: 12px;
        color: #999999;
        transition: transform 0.2s ease;
    }

    .tools-item.has-sub.active::after {
        transform: rotate(180deg);
    }

    .attachment {
        color: #000000;
        /* Default color */
        transition: color 0.2s ease;
    }

    .attachment.active {
        color: #00B7E5;
    }

    /* Mobile adjustments */
    @media (max-width: 768px) {
        .tools-dropdown {
            min-width: 200px;
            left: -50px;
            /* Adjust position if needed */
        }

        .sub-tools-dropdown {
            max-height: none;
            /* No height limit on mobile */
            transition: none;
            /* Disable animation on mobile for simplicity */
            border: none;
            border-top: 1px solid #E4E4E7;
            border-radius: 0;
            opacity: 1;
        }

        .sub-tools-dropdown.active {
            padding: 0 0 10px 0;
        }
    }
</style>

<div class="tools-dropdown" id="toolsDropdown">
    <div class="tools-item has-sub" onclick="toggleSubTools('energy')">
        <i class="fas fa-bolt"></i>
        Energy Tools
    </div>
    <div class="sub-tools-dropdown" id="sub-energy">
        <?php if (isset($_SESSION['energy_mcp_tools'])): ?>
            <?php foreach ($_SESSION['energy_mcp_tools'] as $tool): ?>
                <div class="sub-tools-item" title="<?= htmlspecialchars($tool['description'] ?? '') ?>" onclick="selectSubTool('Energy', '<?= htmlspecialchars($tool['title'] ?? '') ?>')">
                    <?= htmlspecialchars($tool['title'] ?? '') ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="tools-item has-sub" onclick="toggleSubTools('brevo')">
        <i class="fas fa-envelope"></i>
        Brevo Tools
    </div>

    <div class="sub-tools-dropdown" id="sub-brevo">
        <?php if (isset($_SESSION['brevo_mcp_tools'])): ?>
            <?php foreach ($_SESSION['brevo_mcp_tools'] as $tool): ?>
                <div class="sub-tools-item" title="<?= htmlspecialchars($tool['description'] ?? '') ?>" onclick="selectSubTool('Brevo', '<?= htmlspecialchars($tool['title'] ?? '') ?>')">
                    <?= htmlspecialchars($tool['title'] ?? '') ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="tools-item has-sub" onclick="toggleSubTools('xml')">
        <i class="fas fa-code"></i>
        XML Tools
    </div>
    <div class="sub-tools-dropdown" id="sub-xml">
        <?php if (isset($_SESSION['xml_mcp_tools'])): ?>
            <?php foreach ($_SESSION['xml_mcp_tools'] as $tool): ?>
                <div class="sub-tools-item" title="<?= htmlspecialchars($tool['description'] ?? '') ?>" onclick="selectSubTool('XML', '<?= htmlspecialchars($tool['title'] ?? '') ?>')">
                    <?= htmlspecialchars($tool['title'] ?? '') ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
    const energyTools = <?= json_encode($_SESSION['energy_mcp_tools'] ?? []) ?>;
    const brevoTools = <?= json_encode($_SESSION['brevo_mcp_tools'] ?? []) ?>;
    const xmlTools = <?= json_encode($_SESSION['xml_mcp_tools'] ?? []) ?>;

    // Tool lookup function
    function getToolByCategoryAndTitle(category, title) {
        let tools = [];
        if (category === 'Energy') tools = energyTools;
        else if (category === 'Brevo') tools = brevoTools;
        else if (category === 'XML') tools = xmlTools;
        return tools.find(tool => tool.title === title);
    }

    // Helper to cast form values to correct types based on schema
    function castToSchemaType(value, schema) {
        if (!schema || !schema.type) return value;

        if (schema.type === 'boolean') {
            return value === 'true' || value === true;
        } else if (schema.type === 'number' || schema.type === 'integer') {
            return schema.type === 'integer' ? parseInt(value, 10) : parseFloat(value);
        } else if (schema.type === 'string') {
            return String(value);
        } else if (schema.type === 'array' && schema.items) {
            if (typeof value === 'string' && schema.items.type === 'string') {
                return value.split(',').map(item => item.trim()).filter(item => item);
            } else if (typeof value === 'string' && (schema.items.type === 'number' || schema.items.type === 'integer')) {
                return value.split(',').map(item => schema.items.type === 'integer' ? parseInt(item.trim(), 10) : parseFloat(item.trim())).filter(item => !isNaN(item));
            } else if (typeof value === 'string') {
                try {
                    return JSON.parse(value);
                } catch (e) {
                    return value;
                }
            }
            return Array.isArray(value) ? value : [];
        } else if (schema.type === 'object' && schema.properties) {
            const result = {};
            Object.keys(value).forEach(key => {
                if (schema.properties[key]) {
                    result[key] = castToSchemaType(value[key], schema.properties[key]);
                } else {
                    result[key] = value[key];
                }
            });
            return result;
        }
        return value;
    }

    // Recursive function to generate inputs for nested schemas
    function generateInputs(schema, basePath = '', rowCounter = 0) {
        let html = '';
        if (schema.type === 'object' && schema.properties) {
            Object.keys(schema.properties).forEach(prop => {
                const propDef = schema.properties[prop];
                const fullPath = basePath ? `${basePath}.${prop}` : prop;
                const label = capitalizeLabel(fullPath.replace(/\./g, ' ')); // e.g., "Sender Email"
                const isRequired = schema.required?.includes(prop) || false;
                let defaultVal = propDef.default ?? '';
                let inputHtml = '';

                if (propDef.enum) {
                    inputHtml = `<select class="form-input" id="input-${fullPath}" name="${fullPath}">`;
                    (propDef.enum || []).forEach(option => {
                        inputHtml += `<option value="${option}" ${defaultVal === option ? 'selected' : ''}>${option}</option>`;
                    });
                    inputHtml += '</select>';
                } else if (propDef.type === 'number') {
                    inputHtml = `<input type="number" class="form-input" id="input-${fullPath}" name="${fullPath}" value="${defaultVal}" step="any" min="${propDef.minimum ?? ''}" max="${propDef.maximum ?? ''}">`;
                } else if (propDef.type === 'string') {
                    inputHtml = `<input type="text" class="form-input" id="input-${fullPath}" name="${fullPath}" value="${defaultVal}" ${propDef.format === 'email' ? 'type="email"' : ''}>`;
                } else if (propDef.type === 'boolean') {
                    inputHtml = `<select class="form-input" id="input-${fullPath}" name="${fullPath}">
                        <option value="false" ${defaultVal === false || defaultVal === 'false' ? 'selected' : ''}>False</option>
                        <option value="true" ${defaultVal === true || defaultVal === 'true' ? 'selected' : ''}>True</option>
                    </select>`;
                } else if (propDef.type === 'array') {
                    if (propDef.items && ['string', 'number', 'integer'].includes(propDef.items.type)) {
                        // Array of primitives: comma-separated text input
                        let placeholder = `Comma-separated ${propDef.items.type === 'integer' ? 'integers' : propDef.items.type}s, e.g., value1, value2`;
                        let val = defaultVal;
                        if (Array.isArray(defaultVal)) {
                            val = defaultVal.join(', ');
                        }
                        inputHtml = `<input type="text" class="form-input" id="input-${fullPath}" name="${fullPath}" value="${val}" placeholder="${placeholder}">`;
                        html += `
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">${label}${isRequired ? ` <span style="color: #dc3545;">*</span>` : ''}</label>
                                    ${inputHtml}
                                </div>
                            </div>
                        `;
                        rowCounter++;
                        return; // Skip further processing
                    } else if (propDef.items && propDef.items.type === 'object' && propDef.items.properties && Object.keys(propDef.items.properties).length > 0) {
                        // Array of objects: recurse into items.properties to generate sub-inputs (for one item) only if properties defined
                        const subHtml = generateInputs({
                            type: 'object',
                            properties: propDef.items.properties,
                            required: propDef.items.required || []
                        }, fullPath, rowCounter);
                        if (subHtml) { // Only add if there's content
                            html += subHtml;
                            rowCounter += Object.keys(propDef.items.properties || {}).length; // Update counter
                        }
                        return; // Skip adding to current row
                    } else {
                        // Complex array: JSON textarea
                        let val = JSON.stringify(defaultVal ?? [], null, 2);
                        inputHtml = `<textarea class="form-input" id="input-${fullPath}" name="${fullPath}" rows="2" placeholder="JSON array">${val}</textarea>`;
                        html += `
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">${label}${isRequired ? ` <span style="color: #dc3545;">*</span>` : ''}</label>
                                    ${inputHtml}
                                </div>
                            </div>
                        `;
                        rowCounter++;
                        return; // Skip further processing
                    }
                } else if (propDef.type === 'object') {
                    if (propDef.properties && Object.keys(propDef.properties).length > 0) {
                        // Recurse for nested objects with defined properties
                        const subHtml = generateInputs(propDef, fullPath, rowCounter);
                        if (subHtml) { // Only add if there's content
                            html += subHtml;
                            rowCounter += Object.keys(propDef.properties || {}).length; // Update counter for sub-properties
                        }
                        return; // Skip adding to current row
                    } else {
                        // Skip free-form objects without defined properties
                        return;
                    }
                } else {
                    inputHtml = `<input type="text" class="form-input" id="input-${fullPath}" name="${fullPath}" value="${defaultVal}">`;
                }

                if (propDef.type !== 'object' && propDef.type !== 'array') {
                    // Add non-nested/non-array inputs
                    html += `
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">${label}${isRequired ? ` <span style="color: #dc3545;">*</span>` : ''}</label>
                                ${inputHtml}
                            </div>
                        </div>
                    `;
                    rowCounter++;
                }
            });
        }
        return html;
    }

    // Capitalize label words
    function capitalizeLabel(str) {
        return str.replace(/\w\S*/g, txt => txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase());
    }

    function toggleToolsDropdown() {
        const dropdown = document.getElementById('toolsDropdown');
        const icon = document.querySelector('.attachment');
        dropdown.classList.toggle('active');
        icon.classList.toggle('active');
    }

    function toggleSubTools(category) {
        // Close all other sub-dropdowns first
        document.querySelectorAll('.sub-tools-dropdown').forEach(sub => {
            if (sub.id !== 'sub-' + category) {
                sub.classList.remove('active');
                sub.previousElementSibling.classList.remove('active');
            }
        });

        // Toggle the current one
        const subDropdown = document.getElementById('sub-' + category);
        const parentItem = subDropdown.previousElementSibling;
        parentItem.classList.toggle('active');
        subDropdown.classList.toggle('active');
    }

    function selectSubTool(category, toolTitle) {
        const tool = getToolByCategoryAndTitle(category, toolTitle);
        if (!tool || !tool.inputSchema?.properties) {
            alert('Tool schema not found');
            return;
        }

        // Generate inputs HTML with one per line using form-row
        let inputsHtml = '<div class="tab-content tab-padding-remove"><div class="tab-pane fade show active" id="tool-tab-1">';
        let rowCounter = 0;
        inputsHtml += generateInputs(tool.inputSchema, '', rowCounter);
        inputsHtml += '</div></div>'; // Close tab-pane and tab-content

        // Always recreate full modal HTML to avoid null errors on re-open
        const modalHtml = `
            <div class="modal fade" id="toolModal" tabindex="-1" aria-labelledby="toolModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="toolModalLabel">${toolTitle}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="toolModalBody">
                            ${inputsHtml}
                            <div class="mt-3 d-flex justify-content-between">
                                <button type="button" class="btn btn-cancel w-50" onclick="submitTool('${category}', '${tool.name}', '${toolTitle}', 'with-chat')">With Chat</button>
                                <button type="button" class="btn btn-apply w-50" onclick="submitTool('${category}', '${tool.name}', '${toolTitle}', 'without-chat')">Without Chat</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Remove existing modal if present
        const existingModal = document.getElementById('toolModal');
        if (existingModal) {
            existingModal.remove();
        }

        // Append new modal to body
        document.body.insertAdjacentHTML('beforeend', modalHtml);

        // Show modal (Bootstrap 5)
        const modalEl = document.getElementById('toolModal');
        const modal = new bootstrap.Modal(modalEl);
        modal.show();

        // Close dropdowns
        document.getElementById('toolsDropdown').classList.remove('active');
        document.querySelector('.attachment').classList.remove('active');
        document.querySelectorAll('.tools-item.has-sub').forEach(item => item.classList.remove('active'));
        document.querySelectorAll('.sub-tools-dropdown').forEach(sub => sub.classList.remove('active'));
    }

    function submitTool(category, toolName, toolTitle, mode) {
        const tool = getToolByCategoryAndTitle(category, toolTitle);
        if (!tool || !tool.inputSchema?.properties) {
            alert('Tool schema not found');
            return;
        }

        const formData = {};
        const inputs = document.querySelectorAll('#toolModalBody [name]');
        inputs.forEach(el => {
            if (el.type === 'checkbox') {
                formData[el.name] = el.checked;
            } else {
                formData[el.name] = el.value;
            }
        });

        // Cast formData to correct types based on schema
        const typedFormData = {};
        Object.keys(formData).forEach(key => {
            const schemaProp = tool.inputSchema.properties[key];
            typedFormData[key] = castToSchemaType(formData[key], schemaProp);
        });

        console.log('Submitting tool:', toolName, 'Data:', typedFormData, 'Mode:', mode);

        // Close modal
        const modalEl = document.getElementById('toolModal');
        if (modalEl) {
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();
        }

        // If 'with-chat', save selected tool details and show tag
        if (mode === 'with-chat') {
            selectedTool = {
                category: category,
                name: toolName,
                args: typedFormData,
                title: toolTitle
            };
            const selectedTag = document.getElementById('selectedToolTag');
            if (selectedTag) {
                selectedTag.innerHTML = `Selected tool: ${toolTitle} <button class="selected-tool-cross" onclick="clearSelectedTool()">x</button>`;
                selectedTag.classList.add('active');
            }
        }
    }

    // Helper to clear selected tool tag and data
    function clearSelectedTool() {
        selectedTool = null;
        const selectedTag = document.getElementById('selectedToolTag');
        if (selectedTag) {
            selectedTag.innerHTML = '';
            selectedTag.classList.remove('active');
        }
    }

    // Close dropdown on outside click
    document.addEventListener('click', function(event) {
        const icon = document.querySelector('.attachment');
        const dropdown = document.getElementById('toolsDropdown');
        if (!icon.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.classList.remove('active');
            icon.classList.remove('active');
            document.querySelectorAll('.tools-item.has-sub').forEach(item => item.classList.remove('active'));
            document.querySelectorAll('.sub-tools-dropdown').forEach(sub => sub.classList.remove('active'));
        }
    });
</script>