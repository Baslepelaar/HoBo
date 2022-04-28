<?php
require_once 'partial/header.php';
?>
<body>
    <main>
      <div class="row w-100 h-100 justify-content-center mt-5">
        <form id="contact-form" name="contact-form" method="POST">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-8">
              <div class="card card-registration my-4" style="border-radius: 2vh; border: black solid 0px;">
              <div class="row g-0">
                <div class="col-xl-12">
                  <div class="card-body p-md-5 text-black">
                    <h3 class="mb-5 text-center">Contact opnemen</h3>
                    <p class="text-center w-responsive mx-auto mb-5" style="color: black;">Heb je vragen? Neem direct contact op met ons.</p>
                    <div class="row">
                <div class="col-md-9 mb-md-0 w-responsive mx-auto" style="margin-left: 5vw;">
                  <form id="contact-form" name="contact-form" action="mail.php" method="POST">
                 <div class="row">
              <div class="col-md-12">
                <div class="md-form">
                  <input class="text-center mb-1" type="text" id="name" name="name" class="form-control" style="height: 5vh; border-radius: 1vh; border: 2px solid grey;" placeholder="Je naam">
                </div>
              </div>
                <div class="col-md-12">
                  <div class="md-form">
                    <input class="text-center mb-1" type="text" id="email" name="email" class="form-control" style="height: 5vh; border-radius: 1vh; border: 2px solid grey;" placeholder="Je email">
                  </div>
                </div>
              </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="md-form">
                      <input class="text-center mb-1" type="text" id="subject" name="subject" class="form-control" style="height: 5vh; border-radius: 1vh; border: 2px solid grey;" placeholder="Onderwerp">
                    </div>
                  </div>
              </div>
                <div class="row">
                  <div class="col-md-12 mb-5 mt-4">
                    <div class="md-form">
                      <textarea type="text" id="message" name="message" rows="5" class="form-control md-textarea" style="height: 15vh; border-radius: 1vh; border: 2px solid grey;" placeholder="Je vraag aan ons"></textarea>
                    </div>
                </div>
              </div>
            </form>
              <div class="text-center text-md-left">
                <a class="btn btn-primary btn-lg" style="background-color: #02ee5a; border-color: #02ee5a;" onclick="">Verzenden</a>
              </div>
                <div class="status"></div>
              </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>  
      </form> 
    </div>
    </main>
  </body>
<?php
require_once 'partial/footer.php';
?>  