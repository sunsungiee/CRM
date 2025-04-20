const container = document.getElementById('side_bar_menu'); // Родительский контейнер
const button = document.getElementById('task_button'); // Кнопка, которая открывает меню

// Функция для ограничения размера
function adjustFixedContent() {
    const fixedContent = document.getElementById('side_bar_menu_content');
    if (!fixedContent) return;

    const containerWidth = container.clientWidth;
    const fixedContentWidth = fixedContent.clientWidth;

    if (fixedContentWidth > containerWidth) {
        fixedContent.style.width = `${containerWidth}px`;
    }
}

// Наблюдатель за изменениями в DOM
const observer = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
        if (mutation.type === 'childList') {
            adjustFixedContent(); // Проверяем при любом изменении
        }
    });
});

// Начинаем наблюдение
if (container) {
    observer.observe(container, {
        childList: true, // Следим за добавлением/удалением элементов
        subtree: true,   // И за изменениями внутри контейнера
    });
}

// Вызываем вручную при клике на кнопку (на всякий случай)
if (button) {
    button.addEventListener('click', adjustFixedContent);
}

// Вызываем при загрузке и ресайзе
window.addEventListener('resize', adjustFixedContent);