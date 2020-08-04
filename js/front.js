
document.addEventListener('DOMContentLoaded', function(){
    let projects = document.getElementById('projects-block');
    
    document.getElementById('portfolio-sorting').addEventListener('click', 
    sortProjectsById);

  
}, false);

function sortProjectsById(el){
    let datatype = el.target.getAttribute('id');
    
    let active = document.getElementById('portfolio-sorting').querySelector("[class='item active']");
    active.classList.remove('active');
    switch(datatype){
        case 'all-pros':
                el.target.parentElement.classList.add('active');
                let projects = document.getElementById('projects-block');
                let items = projects.querySelectorAll("[class=pro-item]");
                //console.log(items);
                for(let i = 0; i < items.length; i++){
                    items[i].style.display = 'block';
                }
        break;
        case 'bot':
                showAll()
            el.target.parentElement.classList.add('active');
            let logos = document.querySelectorAll("[data-type]:not([data-type='bot'])");
            //console.log(logos);
            for(let i = 0; i < logos.length; i++){
                logos[i].style.display = 'none';
            }
        break;
        case 'front':
                showAll()
                el.target.parentElement.classList.add('active');
                let photo = document.querySelectorAll("[data-type]:not([data-type='front'])");
                //console.log(photo);
                for(let i = 0; i < photo.length; i++){
                    photo[i].style.display = 'none';
                }
        break;
        case 'back':
                showAll()
                el.target.parentElement.classList.add('active');
                let webdeisgn = document.querySelectorAll("[data-type]:not([data-type='back'])");
                //console.log(webdeisgn);
                for(let i = 0; i < webdeisgn.length; i++){
                    webdeisgn[i].style.display = 'none';
                }
        break;

    }
}

function showAll(){
    let projects = document.getElementById('projects-block');
    let items = projects.querySelectorAll("[class=pro-item]");
    //console.log(items);
    for(let i = 0; i < items.length; i++){
        items[i].style.display = 'block';
    }
}


function myFunction(x) {
    
    var menu = document.getElementById('menu');
    menu.classList.toggle('shown');
  
}
