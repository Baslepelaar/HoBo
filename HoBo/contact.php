<?php
require_once 'partial/header.php';
?>
<body>
    <main>
      <section class="row w-100 h-100">
        <article class="forum mt-5" style="justify-content-center">
          <h2 class="h1-responsive font-weight-bold text-center my-4" style="color: white;">Contact opnemen</h2>
            <p class="text-center w-responsive mx-auto mb-5" style="color: white;">Heb je vragen? Neem direct contact op met ons.</p>
              <div class="row">
                <div class="col-md-9 mb-md-0 w-responsive mx-auto mb-5" style="margin-left: 5vw;">
                  <form id="contact-form" name="contact-form" action="mail.php" method="POST">
                 <div class="row">
              <div class="col-md-6">
                <div class="md-form mb-3">
                  <input type="text" id="name" name="name" class="form-control" placeholder="Je naam">
                </div>
              </div>
                <div class="col-md-6">
                  <div class="md-form mb-3">
                    <input type="text" id="email" n ame="email" class="form-control" placeholder="Je email">
                  </div>
                </div>
              </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="md-form mb-3">
                      <input type="text" id="subject" name="subject" class="form-control" placeholder="Onderwerp">
                    </div>
                  </div>
              </div>
                <div class="row">
                  <div class="col-md-12 mb-3">
                    <div class="md-form">
                      <textarea type="text" id="message" name="message" rows="2" class="form-control md-textarea" placeholder="Je vraag aan ons"></textarea>
                    </div>
                </div>
              </div>
            </form>
              <div class="text-center text-md-left">
                <a class="btn btn-primary" style="background-color: #02ee5a; border-color: #02ee5a;" onclick="">Verzenden</a>
              </div>
                <div class="status"></div>
              </div>
            </div>
          </section>
        </section>
      </article>
    </main>
  </body>
<?php
require_once 'partial/footer.php';
?>  