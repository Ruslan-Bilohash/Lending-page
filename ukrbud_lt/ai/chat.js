// chat.js — AI Consultant Grok xAI для Ukrbud.lt (2026 — авто-відкриття + бот говорить першим)
(function () {
    'use strict';

    const API_URL = '/ai/bot.php';
    const HISTORY_URL = '/ai/get-messages.php';
    const SESSION_KEY = 'ukrbud_ai_consultant_session';

    let session = localStorage.getItem(SESSION_KEY);
    if (!session) {
        session = 's_' + Date.now() + '_' + Math.random().toString(36).substring(2, 16);
        localStorage.setItem(SESSION_KEY, session);
    }

    const PRIMARY_COLOR = '#00f5ff';
    const ACCENT_COLOR = '#0099ff';
    const HEADER_GRADIENT = 'linear-gradient(135deg, #00f5ff 0%, #0099ff 100%)';

    const container = document.createElement('div');
    container.id = 'ukrbud-chat';
    container.style.cssText = `
        position:fixed; bottom:20px; right:20px; width:420px; max-width:94vw; height:680px;
        background:rgba(15,15,45,0.97); backdrop-filter:blur(24px);
        border-radius:28px; box-shadow:0 30px 90px -20px rgba(0,245,255,0.65);
        display:none; flex-direction:column; overflow:hidden; z-index:99999;
        border:1px solid rgba(0,245,255,0.45); font-family:system-ui, -apple-system, sans-serif;
        transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    `;

    const header = document.createElement('div');
    header.style.cssText = `
        background:${HEADER_GRADIENT}; color:#000; padding:20px 24px; 
        display:flex; align-items:center; justify-content:space-between;
        font-weight:800; font-size:20px;
    `;
    header.innerHTML = `
        <div style="display:flex; align-items:center; gap:16px;">
            <div style="width:56px;height:56px;background:#000;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:34px;box-shadow:0 0 25px #00f5ff;">🧹</div>
            <div>
                <div>AI Consultant</div>
                <div style="font-size:13.5px;opacity:0.95;">Profesionalus valymo konsultantas Vilniuje</div>
            </div>
        </div>
        <button id="close-chat" style="background:none;border:none;color:#000;font-size:36px;cursor:pointer;line-height:1;">×</button>
    `;

    const messages = document.createElement('div');
    messages.id = 'chat-messages';
    messages.style.cssText = `flex:1; padding:24px 22px; overflow-y:auto; background:rgba(10,10,31,0.96); display:flex; flex-direction:column; gap:16px;`;

    const inputArea = document.createElement('div');
    inputArea.style.cssText = `padding:18px 22px; border-top:1px solid rgba(0,245,255,0.25); background:rgba(15,15,45,0.98); display:flex; gap:12px;`;
    inputArea.innerHTML = `
        <input id="chat-input" type="text" placeholder="Напишіть повідомлення..." 
               style="flex:1; padding:16px 24px; background:rgba(255,255,255,0.08); border:1px solid rgba(0,245,255,0.5); border-radius:9999px; outline:none; font-size:16px; color:#fff;">
        <button id="chat-send" style="background:linear-gradient(90deg,${PRIMARY_COLOR},${ACCENT_COLOR}); color:#000; border:none; border-radius:9999px; width:60px; height:60px; cursor:pointer;font-size:28px;">→</button>
    `;

    container.append(header, messages, inputArea);
    document.body.appendChild(container);

    const openBtn = document.createElement('button');
    openBtn.style.cssText = `
        position:fixed; bottom:28px; right:28px; width:78px; height:78px;
        background:linear-gradient(135deg, ${PRIMARY_COLOR}, ${ACCENT_COLOR}); 
        color:#000; border:none; border-radius:50%; font-size:42px; cursor:pointer; 
        box-shadow:0 25px 55px rgba(0,245,255,0.75); z-index:99998;
    `;
    openBtn.innerHTML = '🧹';
    document.body.appendChild(openBtn);

    function addMsg(text, from) {
        const div = document.createElement('div');
        div.style.cssText = `
            max-width:86%; padding:15px 21px; border-radius:24px; line-height:1.58; font-size:15.8px;
            ${from === 'client' ? 
                `align-self:flex-end; background:linear-gradient(90deg,${PRIMARY_COLOR},${ACCENT_COLOR}); color:#000;` : 
                'align-self:flex-start; background:rgba(255,255,255,0.14); color:#fff;'}
        `;
        div.textContent = text;
        messages.appendChild(div);
        messages.scrollTop = messages.scrollHeight;
    }

    async function loadHistory() {
        try {
            const r = await fetch(`${HISTORY_URL}?session=${encodeURIComponent(session)}`);
            if (r.ok) {
                const history = await r.json();
                messages.innerHTML = '';
                history.forEach(m => addMsg(m.content, m.sender));
            }
        } catch (e) {}
    }

    async function sendMessage() {
        const input = document.getElementById('chat-input');
        const text = input.value.trim();
        if (!text) return;

        addMsg(text, 'client');
        input.value = '';

        try {
            const r = await fetch(API_URL, {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({session, message: text})
            });
            const data = await r.json();
            if (data.reply) addMsg(data.reply, 'bot');
        } catch (e) {
            addMsg('Вибачте, проблема зі зв’язком. Зателефонуйте: +370 644 74842', 'bot');
        }
    }

    // Автоматичне відкриття чату + перше повідомлення від бота
    function autoOpenChat() {
        container.style.display = 'flex';
        openBtn.style.display = 'none';
        loadHistory();

        // Якщо історія порожня — надсилаємо спеціальне перше повідомлення від бота
        setTimeout(async () => {
            if (messages.children.length === 0) {
                const welcomeText = "Sveiki! 🧹 Aš esu AI konsultantas iš Ukrbud.lt. Ar norėtumėte užsisakyti profesionalų valymą po remonto, biuro ar komercinių patalpų? Greitas išvykimas per 60 min, ekologiškos priemonės ir geriausios kainos Vilniuje bei apylinkėse. Papasakokite, kokio valymo jums reikia — aš iš karto apskaičiuosiu kainą ir padėsiu забронювати! ✨";
                addMsg(welcomeText, 'bot');

                // Додаємо це повідомлення в історію через сервер (щоб Grok знав контекст)
                try {
                    await fetch(API_URL, {
                        method: 'POST',
                        headers: {'Content-Type': 'application/json'},
                        body: JSON.stringify({session, message: "__AUTO_WELCOME__"})
                    });
                } catch (e) {}
            }
        }, 800);
    }

    // Авто-відкриття через 4 секунди
    setTimeout(() => {
        if (container.style.display !== 'flex') {
            autoOpenChat();
        }
    }, 4000);

    // Ручне відкриття кнопкою
    openBtn.onclick = () => {
        container.style.display = 'flex';
        openBtn.style.display = 'none';
        loadHistory();
    };

    document.getElementById('close-chat').onclick = () => {
        container.style.display = 'none';
        openBtn.style.display = 'block';
    };

    document.getElementById('chat-send').onclick = sendMessage;
    document.getElementById('chat-input').addEventListener('keypress', e => {
        if (e.key === 'Enter') sendMessage();
    });

    // Мобільна адаптивність
    function makeMobile() {
        if (window.innerWidth < 500 && container.style.display === 'flex') {
            container.style.width = '100%';
            container.style.height = '100%';
            container.style.bottom = '0';
            container.style.right = '0';
            container.style.borderRadius = '0';
        }
    }
    window.addEventListener('resize', makeMobile);
})();