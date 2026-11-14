<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexus AI Studio — AI Platform</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        customBg: '#08090d',
                        cardGlass: 'rgba(20, 24, 33, 0.6)',
                        borderGlass: 'rgba(255, 255, 255, 0.08)',
                        accentPink: '#ec4899',
                        accentBlue: '#3b82f6'
                    }
                }
            }
        }
    </script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-customBg text-gray-100 font-sans min-h-screen flex flex-col relative overflow-x-hidden">

    <!-- Фоновые размытые градиенты (Mesh Glows в стиле Lovable) -->
    <div class="absolute top-[-10%] left-[20%] w-[500px] h-[500px] bg-blue-600/20 rounded-full blur-[130px] pointer-events-none"></div>
    <div class="absolute top-[30%] right-[10%] w-[450px] h-[450px] bg-pink-600/20 rounded-full blur-[130px] pointer-events-none"></div>

    <!-- Шапка сайта -->
    <header class="w-full max-w-7xl mx-auto px-6 py-6 flex justify-between items-center relative z-10">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-pink-500 to-blue-500 flex items-center justify-center shadow-lg shadow-pink-500/20">
                <i data-lucide="sparkles" class="w-4 h-4 text-white"></i>
            </div>
            <span class="font-bold tracking-wider text-lg bg-gradient-to-r from-white to-gray-400 bg-clip-text text-transparent">NEXUS AI</span>
        </div>
        <nav class="hidden md:flex space-x-8 text-sm text-gray-400">
            <a href="#" class="hover:text-white transition">Шаблоны</a>
            <a href="#" class="hover:text-white transition">Возможности</a>
            <a href="#" class="hover:text-white transition">Документация</a>
        </nav>
        <div class="flex items-center space-x-4">
            <span class="text-xs bg-cardGlass border border-borderGlass px-3 py-1.5 rounded-full text-emerald-400 flex items-center">
                <span class="w-2 h-2 bg-emerald-500 rounded-full mr-2 animate-pulse"></span>API Connected
            </span>
        </div>
    </header>

    <!-- Главный экран (Hero Section) -->
    <main class="flex-1 max-w-4xl mx-auto px-6 w-full flex flex-col items-center justify-center text-center relative z-10 py-12">
        
        <!-- Заголовок -->
        <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight text-white mb-4 leading-tight">
            AI-студия разработки <br>на <span class="bg-gradient-to-r from-pink-400 via-purple-400 to-blue-400 bg-clip-text text-transparent">Laravel & OpenAI</span>
        </h1>
        <p class="text-gray-400 text-base md:text-lg max-w-xl mb-10">
            Создавай код, архитектуру и запросы за секунды. Умный ассистент прямо в твоем веб-интерфейсе.
        </p>

        <!-- Блок чата / Промпт-бар (в стиле референса) -->
        <div class="w-full bg-cardGlass backdrop-blur-xl border border-borderGlass rounded-2xl p-4 shadow-2xl relative mb-8">
            <div id="chat-output" class="hidden text-left mb-4 max-h-60 overflow-y-auto space-y-3 p-2 text-sm font-mono border-b border-borderGlass pb-4">
                <!-- Сюда динамически падают ответы -->
            </div>

            <textarea id="prompt-input" rows="2" placeholder="Напиши задачу (например: Создай миграцию и модель для Laravel)..." class="w-full bg-transparent text-white placeholder-gray-500 text-sm focus:outline-none resize-none px-2"></textarea>
            
            <div class="flex justify-between items-center mt-3 pt-3 border-t border-borderGlass">
                <div class="flex space-x-2">
                    <button class="p-2 text-gray-400 hover:text-white hover:bg-white/5 rounded-lg transition" title="Прикрепить файл">
                        <i data-lucide="paperclip" class="w-4 h-4"></i>
                    </button>
                    <button class="p-2 text-gray-400 hover:text-white hover:bg-white/5 rounded-lg transition" title="Загрузить скриншот">
                        <i data-lucide="image" class="w-4 h-4"></i>
                    </button>
                </div>
                <button onclick="sendPrompt()" id="send-btn" class="bg-white hover:bg-gray-200 text-gray-950 font-semibold px-5 py-2 rounded-xl text-sm transition flex items-center space-x-2 shadow-lg">
                    <span>Генерировать</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </button>
            </div>
        </div>

        <!-- Быстрые теги подсказок -->
        <div class="flex flex-wrap justify-center gap-2.5 text-xs">
            <button onclick="setPrompt('Напиши контроллер Laravel для работы с API')" class="bg-cardGlass hover:bg-white/10 border border-borderGlass px-4 py-2 rounded-full text-gray-300 transition">⚡ Laravel Контроллер</button>
            <button onclick="setPrompt('Создай миграцию базы данных для таблицы студентов')" class="bg-cardGlass hover:bg-white/10 border border-borderGlass px-4 py-2 rounded-full text-gray-300 transition">🗄 SQL Миграция</button>
            <button onclick="setPrompt('Как настроить связку FastAPI и PostgreSQL?')" class="bg-cardGlass hover:bg-white/10 border border-borderGlass px-4 py-2 rounded-full text-gray-300 transition">🚀 FastAPI Архитектура</button>
        </div>

    </main>

    <!-- Скрипты -->
    <script>
        lucide.createIcons();

        function setPrompt(text) {
            document.getElementById('prompt-input').value = text;
        }

        async function sendPrompt() {
            const input = document.getElementById('prompt-input');
            const outputContainer = document.getElementById('chat-output');
            const promptText = input.value.trim();

            if (!promptText) return;

            // Показываем блок чата, если он был скрыт
            outputContainer.classList.remove('hidden');

            // Рисуем запрос пользователя
            outputContainer.innerHTML += `
                <div class="text-right text-gray-300 bg-white/5 p-3 rounded-xl">
                    <span class="text-pink-400 font-bold">Вы:</span> ${promptText}
                </div>
            `;
            input.value = '';
            outputContainer.scrollTop = outputContainer.scrollHeight;

            try {
                const response = await fetch('/api/v1/generate/text', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ prompt: promptText })
                });

                const data = await response.json();

                if (response.ok) {
                    outputContainer.innerHTML += `
                        <div class="text-left text-gray-200 bg-blue-500/10 border border-blue-500/20 p-3 rounded-xl">
                            <span class="text-blue-400 font-bold">Nexus AI:</span>
                            <pre class="whitespace-pre-wrap mt-1 font-mono text-xs">${data.response}</pre>
                        </div>
                    `;
                } else {
                    outputContainer.innerHTML += `<div class="text-red-400">Ошибка: ${data.error}</div>`;
                }
            } catch (err) {
                console.error(err);
            }
            outputContainer.scrollTop = outputContainer.scrollHeight;
        }
    </script>
</body>
</html>