// subscriber scripts

function subscriber() {
  try {
     event.preventDefault();
     let subscriber = event.target.querySelector("#subscribeEmail").value;
     let url = "";
     var path = document.location.pathname;
     var directory = "";
     if (path.substring(path.indexOf('/'), path.lastIndexOf('/')).length > 0) {
         url = "../subscriber.php?subscribe-email="+subscriber;
     } else {
         url = "./subscriber.php?subscribe-email="+subscriber;
     }
     if (typeof subscriber !== 'undefined' && subscriber !== '') {
        fetch(url)
        .then(res => {return res.text()})
        .then(data => {
        document.querySelector("#subscriberModal").querySelector(".modal-body").innerHTML = data;
           $("#subscriberModal").modal("show");
        })
        .catch(err => {
          console.error(err);
        });
     } else {
       throw new Error("Please type your email");
     }
  } catch(ex) {
     document.querySelector("#subscriberModal").querySelector(".modal-body").innerHTML = ex.message;
     $("#subscriberModal").modal("show");
  }
}
//@copyRights NajeemB
