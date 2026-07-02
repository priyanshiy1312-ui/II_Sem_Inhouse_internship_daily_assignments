const heading = document.querySelector("h1");
console.log(heading.textContent);
heading.textContent = "js is live"
const btn = document.querySelector("#mybtn");
btn.addEventListener("click",function(){
let count = parseInt(btn.dataset.count||0);
count++;
btn.dataset.count = count;
document.querySelector("#display").textContent = `Clicks:${count}`;
});