function showModifyBtn() {
  document.querySelector(".modifyAddBtn").style.display = "block";
}

function hideModifyBtn() {
  document.querySelector(".modifyAddBtn").style.display = "none";
}

function showAddBtn() {
  document.querySelector(".addBtn").style.display = "block";
}

function hideAddBtn() {
  document.querySelector(".addBtn").style.display = "none";
}

function handleValueChange(e) {
  if (e.value.length > 100) {
    document.querySelector(".length").style.color = "red";
    document.querySelector(".length").innerHTML = 100;
    document.querySelector(".inputText").value = e.value.substring(0, 100);
  } else {
    document.querySelector(".length").style.color = "black";
    document.querySelector(".length").innerHTML = e.value.length;
  }
}
