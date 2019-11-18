function myFunction() {
  var v = document.getElementsByClassName("check");
  for (var i = 0; i< v.length;i++)
  {
    if (v[i].checked == false)
      {
      document.getElementsByClassName("fname")[i].disabled = true;
      }
      else
      {
      document.getElementsByClassName("fname")[i].disabled = false;
      }
   }
}