// Ativar Links do Menu
const links = document.querySelectorAll(".header-menu a");

function activeLink(link) {
  const url = location.href;
  const href = link.href;
  if (url.includes(href)) {
    link.classList.add("active");
  }
}

links.forEach(activeLink);

// Ativar Items do Orçamento

const parameters = new URLSearchParams(location.search);

function activeProduct(parameter) {
  const element = document.getElementById(parameter);
  if (element) {
    element.checked = true;
  }
}

parameters.forEach(activeProduct);

// Perguntas Frequentes
const questions = document.querySelectorAll(".questions button");

function activeQuestion(event) {
  const question = event.currentTarget;
  const controls = question.getAttribute("aria-controls");
  const resp = document.getElementById(controls);

  resp.classList.toggle("ativa");
  const ativa = resp.classList.contains("ativa");
  question.setAttribute("aria-expanded", ativa);
}

function eventQuestions(question) {
  question.addEventListener("click", activeQuestion);
}

questions.forEach(eventQuestions);

// Galeria
const galery = document.querySelectorAll(".item-imagens img");
const galeryContainer = document.querySelector(".item-imagens");

function changeImage(event) {
  const img = event.currentTarget;
  const media = matchMedia("(min-width: 1000px)").matches;
  if (media) {
    galeryContainer.prepend(img);
  }
}

function eventGalery(img) {
  img.addEventListener("click", changeImage);
}

galery.forEach(eventGalery);

// Animação
if (window.SimpleAnime) {
  new SimpleAnime();
}
