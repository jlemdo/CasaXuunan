<div id="background" data-bgimage="url(images/background/2.jpg) fixed"></div>
        <div id="content-absolute">

            <!-- subheader -->
            <section id="subheader" class="no-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h1>Booking</h1>
                        </div>
                    </div>
                </div>
            </section>

            <section id="section-main" class="no-bg no-top" aria-label="section-menu">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 offset-lg-3">
                            <div class="de-content-overlay">
                                <form name="contactForm" id='contact_form' method="post">
                                    <div id="step-1" class="row">

                                        <div class="col-md-12 mb10">
                                            <h4>Choose Date</h4>                                        
                                            <input type="text" id="date-picker" class="form-control" name="date" value="">

                                            <div class="guests-n-rooms">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <h4>Adult</h4>
                                                        <div class="de-number">
                                                            <span class="d-minus">-</span>
                                                            <input type="text" value="1">
                                                            <span class="d-plus">+</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h4>Children</h4>
                                                        <div class="de-number">
                                                            <span class="d-minus">-</span>
                                                            <input type="text" value="0">
                                                            <span class="d-plus">+</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h4>Room</h4>
                                                        <div id="d-room-count" class="de-number">
                                                            <span class="d-minus">-</span>
                                                            <input id="room-count" type="text" value="1">
                                                            <span class="d-plus">+</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="select-room">
                                        <h4>Select Room</h4>
                                        <select name="Room Type" id="room-type" class="form-control">
                                            <option value="Standart Room">Standart Room</option>
                                            <option value="Deluxe Room">Deluxe Room</option>
                                            <option value="Premier Room">Premier Room</option>
                                            <option value="Family Suite">Family Suite</option>
                                            <option value="Luxury Suite">Luxury Suite</option>
                                            <option value="President Suite">President Suite</option>
                                        </select>
                                    </div>

                                    <div id="step-2" class="row">
                                        <h4>Enter your details</h4>

                                        <div class="col-md-6">
                                            <div id='name_error' class='error'>Please enter your name.</div>
                                            <div>
                                                <input type='text' name='Name' id='name' class="form-control" placeholder="Your Name" required>
                                            </div>

                                            <div id='email_error' class='error'>Please enter your valid E-mail ID.</div>
                                            <div>
                                                <input type='email' name='Email' id='email' class="form-control" placeholder="Your Email" required>
                                            </div>

                                            <div id='phone_error' class='error'>Please enter your phone number.</div>
                                            <div>
                                                <input type='text' name='phone' id='phone' class="form-control" placeholder="Your Phone" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div id='message_error' class='error'>Please enter your message.</div>
                                            <div>
                                                <textarea name='message' id='message' class="form-control" placeholder="Your Message"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="g-recaptcha" data-sitekey="copy-your-site-key-here"></div>
                                            <p id='submit' class="mt20">
                                                <input type='submit' id='send_message' value='Submit Form' class="btn btn-line">
                                            </p>
                                        </div>
                                    </div>
                                </form>
                                <div id='success_message' class='success'>Your reservation has been sent successfully.</div>
                                <div id='error_message' class='error'>Sorry, error occured this time sending your message.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- subheader close -->
          