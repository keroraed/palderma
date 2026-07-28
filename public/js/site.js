/**
 * Palderma Landing Page Interactive Core
 */
document.addEventListener('DOMContentLoaded', () => {

    // --- 1. Reveal Animations ---
    const reveals = document.querySelectorAll('.reveal');
    if (reveals.length > 0 && 'IntersectionObserver' in window) {
        const revealObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15 });
        reveals.forEach(el => revealObserver.observe(el));
    } else {
        reveals.forEach(el => el.classList.add('active'));
    }

    // --- 2. Sticky Header Pill & Mobile Menu ---
    const header = document.querySelector('header.site-header');
    const burgerBtn = document.querySelector('[data-nav="burger"]');
    const menuPanel = document.querySelector('[data-menu-panel]');

    if (header) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 260) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        }, { passive: true });
    }

    if (burgerBtn && menuPanel && header) {
        const toggleMenu = () => {
            const isHidden = menuPanel.style.display === 'none' || getComputedStyle(menuPanel).display === 'none';
            if (isHidden) {
                menuPanel.style.display = 'flex';
                header.classList.add('menu-open');
            } else {
                menuPanel.style.display = 'none';
                header.classList.remove('menu-open');
            }
        };

        burgerBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            toggleMenu();
        });

        // Close menu on link click inside panel
        menuPanel.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                menuPanel.style.display = 'none';
                header.classList.remove('menu-open');
            });
        });

        // Outside click close
        document.addEventListener('click', (e) => {
            if (!header.contains(e.target) && menuPanel.style.display !== 'none') {
                menuPanel.style.display = 'none';
                header.classList.remove('menu-open');
            }
        });
    }

    // --- 3. Hero Slider ---
    const slides = document.querySelectorAll('[data-hero-slide]');
    const dots = document.querySelectorAll('[data-hero-dot]');
    const prevBtn = document.querySelector('[data-hero-prev]');
    const nextBtn = document.querySelector('[data-hero-next]');

    if (slides.length > 0) {
        let currentSlide = 0;
        let slideTimer = null;

        const showSlide = (index) => {
            currentSlide = (index + slides.length) % slides.length;
            slides.forEach((slide, i) => {
                slide.style.display = i === currentSlide ? 'block' : 'none';
                slide.style.opacity = i === currentSlide ? '1' : '0';
            });
            dots.forEach((dot, i) => {
                if (i === currentSlide) {
                    dot.style.background = '#ffffff';
                    dot.style.width = '28px';
                    dot.style.borderRadius = '100px';
                } else {
                    dot.style.background = 'rgba(255, 255, 255, 0.4)';
                    dot.style.width = '10px';
                    dot.style.borderRadius = '50%';
                }
            });
        };

        const nextSlide = () => showSlide(currentSlide + 1);
        const prevSlide = () => showSlide(currentSlide - 1);

        const startAutoplay = () => {
            stopAutoplay();
            slideTimer = setInterval(nextSlide, 5000);
        };
        const stopAutoplay = () => {
            if (slideTimer) clearInterval(slideTimer);
        };

        if (nextBtn) nextBtn.addEventListener('click', () => { nextSlide(); startAutoplay(); });
        if (prevBtn) prevBtn.addEventListener('click', () => { prevSlide(); startAutoplay(); });

        dots.forEach((dot, idx) => {
            dot.addEventListener('click', () => { showSlide(idx); startAutoplay(); });
        });

        showSlide(0);
        startAutoplay();
    }

    // --- 4. Stat Counter Animations ---
    const statCounters = document.querySelectorAll('[data-stat-counter]');
    if (statCounters.length > 0 && 'IntersectionObserver' in window) {
        const counterObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const targetVal = parseFloat(el.getAttribute('data-stat-val') || '0');
                    const isDecimal = el.getAttribute('data-stat-val')?.includes('.');
                    const duration = 2000;
                    const startTime = performance.now();

                    const animate = (now) => {
                        const elapsed = now - startTime;
                        const progress = Math.min(elapsed / duration, 1);
                        // Cubic ease-out
                        const easeProgress = 1 - Math.pow(1 - progress, 3);
                        const current = targetVal * easeProgress;

                        el.textContent = isDecimal ? current.toFixed(1) : Math.floor(current).toString();
                        if (progress < 1) {
                            requestAnimationFrame(animate);
                        } else {
                            el.textContent = isDecimal ? targetVal.toFixed(1) : targetVal.toString();
                        }
                    };
                    requestAnimationFrame(animate);
                    observer.unobserve(el);
                }
            });
        }, { threshold: 0.5 });
        statCounters.forEach(el => counterObserver.observe(el));
    }

    // --- 5. Doctor Modal Dialog ---
    const modal = document.querySelector('[data-doctor-modal]');
    const doctorCards = document.querySelectorAll('[data-doctor-card]');
    const doctorDataScript = document.getElementById('doctors-json');

    if (modal && doctorCards.length > 0 && doctorDataScript) {
        try {
            const doctorData = JSON.parse(doctorDataScript.textContent);
            const closeBtn = modal.querySelector('[data-modal-close]');

            const openModal = (doctor) => {
                modal.querySelector('[data-modal-name]').textContent = doctor.name;
                modal.querySelector('[data-modal-spec]').textContent = doctor.specialty;
                modal.querySelector('[data-modal-bio]').textContent = doctor.bio;
                modal.querySelector('[data-modal-exp]').textContent = doctor.experience_display || '';
                modal.querySelector('[data-modal-pat]').textContent = doctor.patients_display || '';

                const img = modal.querySelector('[data-modal-img]');
                if (img) img.src = doctor.image;

                const qualList = modal.querySelector('[data-modal-quals]');
                if (qualList && Array.isArray(doctor.qualifications)) {
                    qualList.innerHTML = doctor.qualifications.map(q => `<li style="margin-bottom:8px;display:flex;align-items:center;gap:8px"><span style="color:#6c1830;font-weight:700">•</span> ${q}</li>`).join('');
                }

                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
                if (closeBtn) closeBtn.focus();
            };

            const closeModal = () => {
                modal.style.display = 'none';
                document.body.style.overflow = '';
            };

            doctorCards.forEach(card => {
                card.addEventListener('click', () => {
                    const docId = card.getAttribute('data-doctor-id');
                    const doctor = doctorData.find(d => d.id == docId);
                    if (doctor) openModal(doctor);
                });
            });

            if (closeBtn) closeBtn.addEventListener('click', closeModal);

            modal.addEventListener('click', (e) => {
                if (e.target === modal) closeModal();
            });

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && modal.style.display === 'flex') {
                    closeModal();
                }
            });
        } catch (err) {
            console.error('Modal init error:', err);
        }
    }

    // --- 6. AJAX Booking Form Submission ---
    const bookingForm = document.querySelector('[data-booking-form]');
    if (bookingForm) {
        bookingForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const submitBtn = bookingForm.querySelector('button[type="submit"]');
            const alertBox = bookingForm.querySelector('[data-form-alert]');
            const honeypot = bookingForm.querySelector('input[name="website_hp"]');

            // Spam trap
            if (honeypot && honeypot.value !== '') {
                return;
            }

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'جاري إرسال الطلب...';
            }

            try {
                const formData = new FormData(bookingForm);
                const response = await fetch('/booking', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    bookingForm.reset();
                    if (alertBox) {
                        alertBox.style.display = 'block';
                        alertBox.style.background = 'rgba(40, 167, 69, 0.15)';
                        alertBox.style.color = '#155724';
                        alertBox.style.border = '1px solid rgba(40, 167, 69, 0.3)';
                        alertBox.textContent = data.message || 'تم حجز موعدك بنجاح!';
                    }
                } else {
                    throw new Error(data.message || 'حدث خطأ أثناء الإرسال. يرجى المحاولة لاحقاً.');
                }
            } catch (error) {
                if (alertBox) {
                    alertBox.style.display = 'block';
                    alertBox.style.background = 'rgba(220, 53, 69, 0.15)';
                    alertBox.style.color = '#721c24';
                    alertBox.style.border = '1px solid rgba(220, 53, 69, 0.3)';
                    alertBox.textContent = error.message;
                }
            } finally {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'تأكيد طلب الحجز';
                }
            }
        });
    }

    // --- 7. "View All Services" Toggle ---
    const servicesToggle = document.querySelector('[data-services-toggle]');
    const servicesPanel = document.querySelector('[data-services-panel]');
    if (servicesToggle && servicesPanel) {
        const toggleIcon = servicesToggle.querySelector('[data-services-toggle-icon]');
        const toggleLabel = servicesToggle.querySelector('[data-services-toggle-label]');
        const labelShow = toggleLabel.textContent;
        const labelHide = 'إخفاء القائمة';
        servicesToggle.addEventListener('click', () => {
            const isOpen = servicesPanel.style.display === 'block';
            servicesPanel.style.display = isOpen ? 'none' : 'block';
            toggleIcon.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
            toggleLabel.textContent = isOpen ? labelShow : labelHide;
            if (!isOpen) {
                servicesPanel.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        });
    }

});
