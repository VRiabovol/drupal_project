const accItem = document.getElementsByClassName("accordionItem");
const accHD = document.getElementsByClassName("accordionItemHeading");
for (let i = 0; i < accHD.length; i++) {
  // eslint-disable-next-line no-use-before-define
  accHD[i].addEventListener("click", toggleItem, false);
}
function toggleItem() {
  const itemClass = this.parentNode.className;
  for (let i = 0; i < accItem.length; i++) {
    accItem[i].className = "accordionItem close";
  }
  if (itemClass === "accordionItem close") {
    this.parentNode.className = "accordionItem open";
  }
}
