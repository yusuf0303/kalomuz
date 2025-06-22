<section class="contact-section fade-up" id="contact">
    <div class="contact-container">
        <div class="contact-form">
            <span class="section-tag">BIZ BILAN BOG‘LANING</span>
            <h2>Savollaringiz bo‘lsa, bizga yozing!</h2>
            <form method="POST" action="{{ route('contact.send') }}">
                @csrf
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="name" name="name" required placeholder="Ism">
                    <label for="name">Ism *</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="email" name="email" required placeholder="Email">
                    <label for="email">Elektron pochta *</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="tel" class="form-control" id="phone" name="phone" required placeholder="Telefon">
                    <label for="phone">Telefon raqam *</label>
                </div>
                <div class="form-floating mb-3">
                    <textarea class="form-control" id="message" name="message" required placeholder="Xabar"></textarea>
                    <label for="message">Xabar *</label>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="agree" name="agree" required>
                    <label class="form-check-label" for="agree">
                        I allow this website to store my submission so they can respond to my inquiry. *
                    </label>
                </div>
                <button type="submit" class="btn btn-success px-4">YUBORISH</button>
                @if(session('success'))
                    <div class="alert alert-success mt-2">{{ session('success') }}</div>
                @endif
            </form>
        </div>
        <!-- Contact info and map -->
        <div class="contact-info">
            <div class="map-placeholder">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d47924.14202156644!2d69.2041276024483!3d41.31108174050709!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38aef4b53cb5e6cf%3A0x816a066dff75d1d0!2sTashkent%2C%20Uzbekistan!5e0!3m2!1sen!2sus!4v1683800000000!5m2!1sen!2sus"
                    width="100%"
                    height="200"
                    style="border:0; border-radius: 4px;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>


            <div class="info-block">
                <h3>Biz bilan bog‘laning</h3>
                <p>📞 <a href="tel:+998882851606">+998882851606</a></p>
                <p>📧 <a href="mailto:kalomuz.info@gmail.com">kalomuz.info@gmail.com</a></p>
                <!-- <p><a href="#">Instagram</a> | <a href="#">YouTube</a></p> -->
                <div class="social-icons">
                    <a href="https://www.instagram.com/kalomuz/?utm_source=ig_web_button_share_sheet" target="_blank" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://youtube.com/@KalomUz" target="_blank" aria-label="YouTube">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a href="https://t.me/KalomUz_News" target="_blank" aria-label="Telegram">
                        <i class="fab fa-telegram"></i>
                    </a>
                    <a href="https://t.me/KalomUzBot" target="_blank" aria-label="Telegram Bot">
                        <i class="fab fa-telegram"></i>
                    </a>
                    <a href="https://t.me/KalomUzSupportBot" target="_blank" aria-label="Telegram Support Bot">
                        <i class="fab fa-telegram"></i>
                    </a>
                </div>


                <h4>Location</h4>
                <p>Tashkent, Uzbekistan 700005</p>

                <h4>Hours</h4>
                <ul>
                    <li>Dushanba–Juma: 9:00 dan – 22:00 gacha</li>
                    <li>Shanba: 9:00 dan – 18:00 gacha</li>
                    <li>Yakshanba: 9:00 dan – 12:00 gacha</li>
                </ul>
            </div>
        </div>
    </div>
</section>
