<footer>
<style>
.column-derecha{ display: grid;
  justify-items: end;
}
@media (max-width: 576px) {
  .column-right {
    justify-items: center;
  }
}

@media (max-width: 576px) {
  .column-derecha {
    justify-items: center;
  }
}

</style>
        <section id="contact" class="p-3">
        <div class="container">
  <div class="row">
    <div class="col-12 col-sm-6  column-right  col-md-4 mt-3">
      <?php dynamic_sidebar('accesibility-footer-1') ?>
    </div>

    <div class="col-12 col-sm-6 col-md-4 column-derecha mt-5">
      <?php dynamic_sidebar('accesibility-footer-2') ?>
    </div>

    <div class="col-12 col-sm-6 col-md-4 column-derecha">
      <?php dynamic_sidebar('accesibility-footer-3') ?>
    </div>
  </div>
</div>
            </div>
        </section>
        <section id="powered-by">
            <div class="container text-center pt-3 pb-3">
                <p class="alignfooter">
                    <a href="https://www.paraguay.gov.py/guia-estandar">Basado en la Guía estándar para sitios web del Gobierno</a>
                </p>
                <img src="<?php echo get_template_directory_uri() . '/images/dgti.jpg'; ?>" class="img-fluid" alt="Marca producto/servicio MUVH">            </div>
        </section>
    </footer>

    <div class="mobile-menu-overlay"></div>

    <?php wp_footer() ?>
</body>
</html>