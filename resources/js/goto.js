const el = document.querySelector("[data-go]");
const goto = document.querySelector(el.dataset.go).offsetTop;

if (el && goto) {
  el.addEventListener("click", (e) => {
    e.preventDefault();
    window.scroll({
      top: goto,
      behavior: "smooth"
    });
  });
}
