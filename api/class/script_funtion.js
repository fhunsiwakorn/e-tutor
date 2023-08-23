// /Checkbox
function toggle(source) {
  var checkboxes = document.querySelectorAll('input[type="checkbox"]');
  for (var i = 0; i < checkboxes.length; i++) {
    if (checkboxes[i] != source) checkboxes[i].checked = source.checked;
  }
}
// /Checkbox2
var checkflag_d1 = "false";
function checkAll_d1(field) {
  if (checkflag_d1 == "false") {
    for (i = 0; i < field.length; i++) {
      field[i].checked = true;
    }
    checkflag_d1 = "true";
  } else {
    for (i = 0; i < field.length; i++) {
      field[i].checked = false;
    }
    checkflag_d1 = "false";
  }
}
// PRIVIEW PICTURE
function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      $("#blah").attr("src", e.target.result);
    };

    reader.readAsDataURL(input.files[0]);
  }
}

// กรอกแต่ตัวเลข
function chkNumber(ele) {
  var vchar = String.fromCharCode(event.keyCode);
  if ((vchar < "0" || vchar > "9") && vchar != ".") return false;
  ele.onKeyPress = vchar;
}

/////พิมพ์เฉพาะกรอบ div
function printDiv(divName) {
  var printContents = document.getElementById(divName).innerHTML;
  var originalContents = document.body.innerHTML;

  document.body.innerHTML = printContents;

  window.print();

  document.body.innerHTML = originalContents;
}

// JavaScript โปรแกรมตรวจเลขบัตรประชาชน
function checkID(id) {
  if (id.length != 13) return false;
  for (i = 0, sum = 0; i < 12; i++) sum += parseFloat(id.charAt(i)) * (13 - i);
  if ((11 - (sum % 11)) % 10 != parseFloat(id.charAt(12))) return false;
  return true;
}
// function checkForm() {
//   if (!checkID(document.form1.txtID.value)) alert("รหัสประชาชนไม่ถูกต้อง");
//   else alert("รหัสประชาชนถูกต้อง เชิญผ่านได้");
// }
