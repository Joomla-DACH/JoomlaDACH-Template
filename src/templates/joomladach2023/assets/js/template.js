window.addEventListener('DOMContentLoaded', () => {
  for (let accordionItem of document.querySelectorAll('.accordion__item')) {
    accordionItem.querySelector('.accordion__item-trigger').addEventListener('click', (e) => {
      e.target.toggleAttribute('aria-expanded')
      accordionItem.querySelector('.accordion__item-panel').classList.toggle('open');
    })
  }
})
