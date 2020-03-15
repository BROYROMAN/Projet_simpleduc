

function checkUncheckALL(){
 var but = document.getElementById('butt');
 var action = but.value;
 var checkboxes = document.getElementsByTagName('input');
 
 if(action==1){
	console.log("cocher tout");
	   for (var i = 0; i < checkboxes.length; i++) {
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = true;
             }
		}
	but.value=0;
 }else{
	console.log("décocher tout");
	for (var i = 0; i < checkboxes.length; i++) {
      if (checkboxes[i].type == 'checkbox') {
          checkboxes[i].checked = false;
      }
	}
	but.value=1;
 }
 

}


(function()
{

	//exclude older browsers by the features we need them to support
	//and legacy opera explicitly so we don't waste time on a dead browser
	
	
	//get the collection of draggable items and add their draggable attribute
	for(var 
		items = document.querySelectorAll('[data-draggable="item"]'), 
		len = items.length, 
		i = 0; i < len; i ++)
	{
		items[i].setAttribute('draggable', 'true');
                

	}

	//variable for storing the dragging item reference 
	//this will avoid the need to define any transfer data 
	//which means that the elements don't need to have IDs 
	var item = document.getElementById("test1","test2");
        var list = [];
				$(item).find('li').each(function(){
				list.push($(this).html());
				});
				//alert("Table selectionnée : "+list);
                                
 
				
	//dragstart event to initiate mouse dragging
        
	document.addEventListener('dragstart', function(e)
	{
		//set the item reference to this element
		item = e.target;
                
		
		//we don't need the transfer data, but we have to define something
		//otherwise the drop action won't work at all in firefox
		//most browsers support the proper mime-type syntax, eg. "text/plain"
		//but we have to use this incorrect syntax for the benefit of IE10+
		e.dataTransfer.setData('text', item);
	
	}, false);

	//dragover event to allow the drag by preventing its default
	//ie. the default action of an element is not to allow dragging 
	document.addEventListener('dragover', function(e)
	{
            
		if(item)
		{
			e.preventDefault();
                        
		}
	
	}, false);	

	//drop event to allow the element to be dropped into valid targets
	document.addEventListener('drop', function(e)
	{
            
           
		//if this element is a drop target, move the item here 
		//then prevent default to allow the action (same as dragover)
		if(e.target.getAttribute('data-draggable') == 'target')
		{
			e.target.appendChild(item);
			
			e.preventDefault();
                     
                
              
   updateEquipe(item.id,document.getElementById("selectEquipe").value);
   
		}
                
                
	
	}, false);
	
	//dragend event to clean-up after drop or abort
	//which fires whether or not the drop target was valid
	document.addEventListener('dragend', function(e)
	{
            
                  
       
        


                             
		item = null;
               //alert(test2[i].id); 
               // console.log(test2[i].id+"  1er  tableau");
	
       
	
	}, false);
        
        



})();	

function LoadEquipe(id)
{
    var xhr = new XMLHttpRequest();
xhr.open("POST", "../../Application/web/index.php?page=loadEquipe", true);
xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
xhr.send("id=" + id);
xhr.onreadystatechange=function(){
    if (xhr.readyState===4){
            document.getElementById("listedev").innerHTML=xhr.response;

    }
}
}

function updateEquipe(devid,idequipe)
{
    var xhr = new XMLHttpRequest();
xhr.open("POST", "../../Application/web/index.php?page=updateE", true);
xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
xhr.send("iddev=" + devid+"&idequipe=" + idequipe);

}



function LoadOutils(id)
{
    var xhr = new XMLHttpRequest();
xhr.open("POST", "../../Application/web/index.php?page=loadOutils", true);
xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
xhr.send("id=" + id);
xhr.onreadystatechange=function(){
    if (xhr.readyState===4){
            document.getElementById("listeoutils").innerHTML=xhr.response;

    }
}
}
function validateForm() {
  var x = document.forms["myForm"]["fname"].value;
  if (x == "") {
    alert("Name must be filled out");
    return false;
  }
}


