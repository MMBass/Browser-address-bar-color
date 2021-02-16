const color_inputs_list = document.getElementsByClassName("color-inputs");
const check_inputs_list = document.getElementsByClassName("check-inputs");
const txt_cover_input = document.getElementsByClassName("txt-cover-input");
const check_cover_input = document.getElementsByClassName("check-cover-input");
const inp_all = document.getElementById("input_all");
const cbox_all = document.getElementById("cbox_all");
const txt_inp_all = document.getElementById("txt-cover-inp-all");

if(cbox_all.checked){
  all_inputs_cover();
  inp_all.style.display = "block";
  txt_inp_all.style.display = "none";
}; // block all inputs if all selected or not, on page start
if(!cbox_all.checked){
  all_inputs_cover();
  inp_all.style.display = "none";
  txt_inp_all.style.display = "block";
}; // block all inputs if all selected or not, on page start

function disable_unselected(){
  for(let i = 0; i < color_inputs_list.length; i++){
      if(!check_inputs_list[i].checked){
          color_inputs_list[i].style.display = "none";
          txt_cover_input[i].style.display = "block";
      }else if(check_inputs_list[i].checked){
          color_inputs_list[i].style.display = "block";
          check_inputs_list[i].style.display = "inline-block";
          check_cover_input[i].style.display = "none";
          txt_cover_input[i].style.display = "none";
      }
  }  
}; // loop and disable on page start
disable_unselected();

cbox_all.addEventListener("click",()=>{
  inp_all.disabled = !cbox_all.checked;
    if(!cbox_all.checked){
      all_inputs_cover();
      inp_all.style.display = "none";
      txt_inp_all.style.display = "block";
    }else if(cbox_all.checked){
      all_inputs_cover();
      inp_all.style.display = "block";
      txt_inp_all.style.display = "none";
    }
});

function all_inputs_cover(){
  for(let i = 0; i < color_inputs_list.length; i++){
      if(cbox_all.checked){
          color_inputs_list[i].style.display = "none";
          check_inputs_list[i].style.display = "none";
          check_cover_input[i].style.display = "inline-block";
          txt_cover_input[i].style.display = "block";
      }
      if(!cbox_all.checked){
          check_cover_input[i].style.display = "none";
          check_inputs_list[i].style.display = "inline-block";

          if(check_inputs_list[i].checked){
            color_inputs_list[i].style.display = "block";
            txt_cover_input[i].style.display = "none";
          } // recover the color only if already selected
      }
  };
}


// Clicking one page:
for(let i = 0; i < check_inputs_list.length; i++){
  check_inputs_list[i].addEventListener("click",()=>{
      if(!cbox_all.checked){
          setTimeout(() => {
            if(check_inputs_list[i].checked){
              color_inputs_list[i].style.display = "block";
              txt_cover_input[i].style.display = "none";
            }
            if(!check_inputs_list[i].checked){
              color_inputs_list[i].style.display = "none";
              txt_cover_input[i].style.display = "block";
            }  
          }, 1); // making this change async
      }
  });
};

