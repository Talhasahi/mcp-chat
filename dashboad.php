<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCP Chat - AI Desk</title>
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #FFFFFF;
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            min-height: 100vh;
            overflow: hidden;
        }

        .sidebar {
            width: 60px;
            background-color: #1a1a1a;
            color: #FFFFFF;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px 0;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            z-index: 1000;
        }

        .sidebar .logo {
            width: 50px;
            margin-bottom: 20px;
        }

        .sidebar .menu-item {
            margin: 5px 0;
            font-size: 18px;
            color: #808080;
            cursor: pointer;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .sidebar .menu-item.active {
            color: #00B7E5;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar .menu-item:hover {
            color: #00B7E5;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar .settings-icon {
            font-size: 18px;
            color: #808080;
            cursor: pointer;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s ease;
            margin-bottom: 5px;
        }

        .sidebar .settings-icon:hover {
            color: #00B7E5;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar .user-avatar {
            width: 40px;
            border-radius: 50%;
            margin-top: auto;
            margin-bottom: 10px;
        }

        .main-content {
            flex: 1;
            margin-left: 60px;
            padding: 0 20px 120px 20px;
            overflow-y: auto;
            height: 100vh;
        }

        .main-header {
            display: flex;
            align-items: center;
        }

        .main-header .back-icon {
            font-size: 18px;
            color: #808080;
            margin-right: 10px;
            cursor: pointer;
        }

        .main-header .title {
            font-size: 18px;
            color: #000000;
            margin: 0;
        }

        .main-header-line {
            width: 100%;
            border: 0;
            height: 1px;
            background-color: #E2E4E9;
            margin: 5px 0 10px 0;
        }

        .central-logo {
            width: 50px;
            margin: 10px auto 10px auto;
            display: block;
        }

        .main-heading {
            font-size: 32px;
            font-weight: 600;
            color: #000000;
            text-align: center;
            margin-bottom: 10px;
        }

        .main-subtext {
            font-size: 14px;
            color: #000000;
            text-align: center;
            max-width: 600px;
            margin-bottom: 20px;
            margin-left: auto;
            margin-right: auto;
        }

        .mpc-chat-btn {
            background-color: #00B7E5;
            border: 1px solid #00B7E5;
            color: #FFFFFF;
            border-radius: 25px;
            padding: 8px 20px;
            transition: all 0.3s ease;
            font-size: 14px;
            cursor: pointer;
            display: block;
            margin: 10px auto 40px auto;
            width: auto;
            max-width: 200px;
            text-align: center;
        }

        .mpc-chat-btn:hover {
            background-color: #FFFFFF;
            border: 1px solid #00B7E5;
            color: #00B7E5;
        }

        .prompt-cards {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }

        .prompt-card {
            background-color: #FFFFFF;
            border: 1px solid #E4E4E7;
            border-radius: 10px;
            padding: 20px;
            width: 250px;
            text-align: left;
            position: relative;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .prompt-card h3 {
            font-size: 18px;
            font-weight: 600;
            color: #000000;
            margin-bottom: 10px;
        }

        .prompt-card p {
            font-size: 12px;
            color: #808080;
        }

        .prompt-card .arrow {
            position: absolute;
            top: 10px;
            right: 10px;
            color: #808080;
            font-size: 14px;
        }

        .suggested-prompts {
            position: fixed;
            bottom: 60px;
            left: 60px;
            right: 0;
            background-color: #FFFFFF;
            padding: 10px 20px;
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            gap: 10px;
            z-index: 999;
            white-space: nowrap;
        }

        .suggested-prompt {
            background-color: #FFFFFF;
            border: 1px solid #E4E4E7;
            border-radius: 25px;
            padding: 10px 20px;
            font-size: 12px;
            color: #000000;
            cursor: pointer;
            display: inline-block;
        }

        .suggested-prompt i {
            color: #FFD700;
            margin-right: 5px;
        }

        .chat-input {
            position: fixed;
            bottom: 0;
            left: 60px;
            right: 0;
            background-color: #FFFFFF;
            border-top: 1px solid #E4E4E7;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            z-index: 1000;
        }

        .chat-input .attachment {
            color: #808080;
            font-size: 20px;
            margin-right: 10px;
            cursor: pointer;
        }

        .chat-input input {
            flex: 1;
            border: none;
            outline: none;
            font-size: 14px;
            padding: 10px;
            background-color: #F0F0F0;
            border-radius: 25px;
            margin-right: 10px;
        }

        .chat-input .emoji,
        .chat-input .mic {
            color: #808080;
            font-size: 20px;
            margin-right: 10px;
            cursor: pointer;
        }

        .chat-input .send-btn {
            background-color: #00B7E5;
            color: #FFFFFF;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 50px;
            }

            .main-content {
                margin-left: 50px;
                padding: 0 15px 100px 15px;
            }

            .main-header {
                margin: 5px 0 5px 0;
            }

            .main-header-line {
                margin: 3px 0 8px 0;
            }

            .central-logo {
                width: 40px;
            }

            .main-heading {
                font-size: 24px;
            }

            .main-subtext {
                font-size: 12px;
                max-width: 90%;
            }

            .mpc-chat-btn {
                max-width: 100%;
                padding: 6px 15px;
                font-size: 12px;
            }

            .prompt-cards {
                flex-direction: column;
                gap: 15px;
            }

            .prompt-card {
                width: 100%;
                max-width: 300px;
                margin: 0 auto;
            }

            .suggested-prompts {
                left: 50px;
                bottom: 50px;
                padding: 10px 15px;
                flex-wrap: nowrap;
                overflow-x: auto;
            }

            .suggested-prompt {
                font-size: 11px;
                padding: 8px 15px;
            }

            .chat-input {
                left: 50px;
                padding: 8px 15px;
            }

            .chat-input input {
                font-size: 12px;
                padding: 8px;
            }

            .chat-input .attachment,
            .chat-input .emoji,
            .chat-input .mic {
                font-size: 18px;
            }

            .chat-input .send-btn {
                width: 36px;
                height: 36px;
            }
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <img src="assets/images/logo-icon.png" alt="MCP Chat Logo" class="logo">
        <div class="menu-item active"><i class="fas fa-home"></i></div>
        <div class="menu-item"><i class="fas fa-layer-group"></i></div>
        <div class="menu-item"><i class="fas fa-plus"></i></div>
        <div class="settings-icon"><i class="fas fa-cog"></i></div>
        <img src="assets/images/user-avatar.png" alt="User Avatar" class="user-avatar">
    </div>
    <div class="main-content">
        <div class="main-header" style="margin: 10px 0 5px 0;">
            <i class="fas fa-home"></i>
            <p class="title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AI Desk</p>
        </div>
        <hr class="main-header-line">
        <img src="assets/images/logo-icon.png" alt="Central Logo" class="central-logo">
        <h1 class="main-heading">How can we assist you today?</h1>
        <p class="main-subtext">Get instant support from curated AI prompts crafted for productivity, creativity, and decision-making. Choose a prompt to get started, or explore more from the Prompt Library.</p>
        <button class="mpc-chat-btn">Explore More Prompts →</button>
        <div class="prompt-cards">
            <div class="prompt-card">
                <h3>Brainstorm Ideas</h3>
                <p>Unlock creative solutions, business names, or marketing angles in seconds.</p>
                <span class="arrow">→</span>
            </div>
            <div class="prompt-card">
                <h3>Summarize Key Insights</h3>
                <p>Paste long content and instantly get a sharp, executive summary.</p>
                <span class="arrow">→</span>
            </div>
            <div class="prompt-card">
                <h3>Polish My Writing</h3>
                <p>Improve grammar, clarity, and tone of your drafts or messages.</p>
                <span class="arrow">→</span>
            </div>
            <div class="prompt-card">
                <h3>Generate a Strategy Plan</h3>
                <p>Build a quick outline or action plan for your project or team goals.</p>
                <span class="arrow">→</span>
            </div>
        </div>
    </div>
    <div class="suggested-prompts">
        <div class="suggested-prompt"><i class="fas fa-lightbulb"></i>Suggest taglines for a luxury perfume</div>
        <div class="suggested-prompt"><i class="fas fa-lightbulb"></i>What are some launch campaign ideas?</div>
        <div class="suggested-prompt"><i class="fas fa-lightbulb"></i>Give me 5 name ideas for a skincare brand</div>
        <div class="suggested-prompt"><i class="fas fa-lightbulb"></i>Write a LinkedIn post announcing a product launch</div>
    </div>
    <div class="chat-input mb-2">
        <i class="fas fa-paperclip attachment"></i>
        <input type="text" placeholder="Message to Ai Chat...">
        <i class="far fa-smile emoji"></i>
        <i class="fas fa-microphone mic"></i>
        <button class="send-btn"><i class="fas fa-paper-plane"></i></button>
    </div>
</body>

</html>