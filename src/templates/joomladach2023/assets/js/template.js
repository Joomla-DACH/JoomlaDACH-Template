// Offcanvas

document.addEventListener('DOMContentLoaded', () => {
  document.querySelector('.headerbar__content-navtoggler').addEventListener('click', () => {
    document.body.classList.toggle('activenav');
  })
})

// Navigation Functionality
for (let parentMenuItem of document.querySelectorAll('.headerbar__content-mainnav li.parent')) {
  parentMenuItem.querySelector('a, span').addEventListener('click', (e) => {
    if (window.innerWidth < 992) {
      e.preventDefault();
      parentMenuItem.classList.toggle('clicked');
    }
  })
}
// Searchtoggle
document.addEventListener('DOMContentLoaded', () => {
  for (let searchToggle of document.querySelectorAll('.modfinderheaderbar__toggle')) {
    searchToggle.addEventListener('click', () => {
      document.body.classList.toggle('activesearch');
    })
  }
})
