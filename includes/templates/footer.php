            <!-- WhatsApp Floating Button -->
            <div class="whatsapp-float">
                <a href="https://api.whatsapp.com/send?phone=5219852580599&text=<?php echo urlencode(getCurrentLanguage() === 'es' ? '¡Hola! Me gustaría obtener información sobre Casa Xu\'unan' : 'Hi! I would like to get information about Casa Xu\'unan'); ?>"
                   class="whatsapp-float-btn"
                   target="_blank"
                   rel="noopener noreferrer"
                   aria-label="WhatsApp">
                    <i class="fa fa-whatsapp"></i>
                </a>
                <span class="whatsapp-float-tooltip"><?php echo getCurrentLanguage() === 'es' ? '¿Necesitas ayuda?' : 'Need help?'; ?></span>
            </div>

            <!-- footer begin -->
            <footer class="no-top pl20 pr20">
                <div class="subfooter">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">&copy; <?php echo t('footer_copyright'); ?> <?php echo date('Y') ?> - Casa Xuunan <?php echo t('footer_by'); ?> <span class="id-color">PixelCrafters</span></div>
                            <div class="col-md-6 text-right">
                                <div class="social-icons">
                                    <a href="https://www.facebook.com/people/Casa-Xuunan/61578964945156/" target="_blank"><i class="fa fa-facebook fa-lg"></i></a>
                                    <a href="https://www.instagram.com/casa_xuunan/" target="_blank"><i class="fa fa-instagram fa-lg"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="#" id="back-to-top"></a>
            </footer>
            <!-- footer close -->
        </div>