let url = location.pathname.split('/');
let active = url[url.length - 1];

active = (active === '') ? '/' : active;

let padre = document.querySelector(`a[href='${active}']`).parentNode;

padre.classList.add('active');