window.addEventListener('DOMContentLoaded', () => {
  for (let accordionItem of document.querySelectorAll('.accordion__item')) {
    accordionItem.querySelector('.accordion__item-trigger').addEventListener('click', (e) => {
      accordionItem.querySelector('.accordion__item-panel').classList.toggle('open');

      if (e.target.getAttribute('aria-expanded') === 'true') {
        e.target.setAttribute('aria-expanded' , 'false')
        return;
      }
      e.target.setAttribute('aria-expanded' , 'true')
    })
  }
})
