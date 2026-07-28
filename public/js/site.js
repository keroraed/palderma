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
                        'Accept': 'application/json',
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

    // --- 7. "Book This Service" -> pre-select in booking form ---
    const bookingSelect = document.querySelector('select[name="service_option_id"]');

    const applyServiceOption = (id) => {
        if (!bookingSelect || !id) return;
        const optionExists = Array.from(bookingSelect.options).some(o => o.value === String(id));
        if (optionExists) {
            bookingSelect.value = String(id);
        }
    };

    // Same-page click (service card is on the homepage already): set + smooth scroll, no reload.
    document.querySelectorAll('[data-book-service]').forEach(link => {
        link.addEventListener('click', (e) => {
            // Card itself opens the details modal on click; this link must handle its
            // own "go book this" action instead, not bubble up and open the modal too.
            e.stopPropagation();

            // If this link lives inside the service detail modal, close it first
            // so the booking form underneath is actually visible.
            const parentModal = link.closest('[data-service-modal]');
            if (parentModal) {
                parentModal.style.display = 'none';
                document.body.style.overflow = '';
            }

            const optionId = link.getAttribute('data-service-option-id');
            if (bookingSelect && optionId) {
                e.preventDefault();
                applyServiceOption(optionId);
                document.getElementById('book')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
            // If there's no matching select on this page (e.g. the standalone
            // /services page), let the link navigate normally to /#book,
            // but first attach the option id as a query param so the
            // destination page can pick it up on load (see below).
            else if (optionId) {
                e.preventDefault();
                window.location.href = '/?service_option=' + encodeURIComponent(optionId) + '#book';
            }
        });
    });

    // Cross-page arrival (came from /services with ?service_option=ID#book): apply on load.
    const urlParams = new URLSearchParams(window.location.search);
    const incomingServiceOption = urlParams.get('service_option');
    if (incomingServiceOption) {
        applyServiceOption(incomingServiceOption);
        setTimeout(() => {
            document.getElementById('book')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }, 100);
    }

    // --- 7b. Service Detail Modal (click card, not the "book" link) ---
    const serviceModal = document.querySelector('[data-service-modal]');
    const serviceCards = document.querySelectorAll('[data-service-card]');
    const serviceDataScript = document.getElementById('services-json');

    if (serviceModal && serviceCards.length > 0 && serviceDataScript) {
        try {
            const serviceData = JSON.parse(serviceDataScript.textContent);
            const closeBtn = serviceModal.querySelector('[data-service-modal-close]');

            const openServiceModal = (service) => {
                serviceModal.querySelector('[data-service-modal-title]').textContent = service.title;

                const iconWrap = serviceModal.querySelector('[data-service-modal-icon-wrap]');
                iconWrap.innerHTML = service.icon_type === 'material'
                    ? `<span class="material-symbols-outlined" style="font-size:30px">${service.icon_value}</span>`
                    : service.icon_value;

                const detailsEl = serviceModal.querySelector('[data-service-modal-details]');
                const detailsText = service.details || service.description;
                detailsEl.textContent = detailsText;
                detailsEl.style.display = detailsText ? 'block' : 'none';

                const featuresWrap = serviceModal.querySelector('[data-service-modal-features-wrap]');
                const featuresList = serviceModal.querySelector('[data-service-modal-features]');
                if (Array.isArray(service.features) && service.features.length > 0) {
                    featuresList.innerHTML = service.features.map(f => `<li style="margin-bottom:8px;display:flex;align-items:center;gap:8px"><span style="color:#6c1830;font-weight:700">•</span> ${f}</li>`).join('');
                    featuresWrap.style.display = 'block';
                } else {
                    featuresWrap.style.display = 'none';
                }

                const noteEl = serviceModal.querySelector('[data-service-modal-note]');
                noteEl.textContent = service.details_note || '';
                noteEl.style.display = service.details_note ? 'block' : 'none';

                const waLink = serviceModal.querySelector('[data-service-modal-whatsapp]');
                const waLabel = serviceModal.querySelector('[data-service-modal-whatsapp-label]');
                if (service.booking_option_id) {
                    waLink.setAttribute('data-service-option-id', service.booking_option_id);
                } else {
                    waLink.removeAttribute('data-service-option-id');
                }
                waLabel.textContent = `احجزي موعدك الآن لخدمة "${service.title}"`;

                serviceModal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
                if (closeBtn) closeBtn.focus();
            };

            const closeServiceModal = () => {
                serviceModal.style.display = 'none';
                document.body.style.overflow = '';
            };

            serviceCards.forEach(card => {
                card.addEventListener('click', () => {
                    const id = card.getAttribute('data-service-id');
                    const service = serviceData.find(s => s.id == id);
                    if (service) openServiceModal(service);
                });
            });

            if (closeBtn) closeBtn.addEventListener('click', closeServiceModal);

            serviceModal.addEventListener('click', (e) => {
                if (e.target === serviceModal) closeServiceModal();
            });

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && serviceModal.style.display === 'flex') {
                    closeServiceModal();
                }
            });
        } catch (err) {
            console.error('Service modal init error:', err);
        }
    }

    // --- 8. FAQ Accordion ---
    document.querySelectorAll('[data-faq-item]').forEach(item => {
        const toggle = item.querySelector('[data-faq-toggle]');
        const answer = item.querySelector('[data-faq-answer]');
        const icon = item.querySelector('[data-faq-icon]');
        if (!toggle || !answer || !icon) return;

        toggle.addEventListener('click', () => {
            const isOpen = answer.style.display === 'block';
            // Close all other open items (classic single-open accordion)
            document.querySelectorAll('[data-faq-answer]').forEach(a => { a.style.display = 'none'; });
            document.querySelectorAll('[data-faq-icon]').forEach(i => {
                i.textContent = 'add';
                i.style.transform = 'rotate(0deg)';
            });
            if (!isOpen) {
                answer.style.display = 'block';
                icon.textContent = 'remove';
                icon.style.transform = 'rotate(180deg)';
            }
        });
    });

    // --- 9. Before/After Compare Slider Carousel ---
    document.querySelectorAll('[data-compare-card]').forEach(card => {
        const handle = card.querySelector('[data-compare-handle]');
        const afterImg = card.querySelector('[data-compare-after]');
        if (!handle || !afterImg) return;

        let dragging = false;

        const setPosition = (clientX) => {
            const rect = card.getBoundingClientRect();
            let pct = ((clientX - rect.left) / rect.width) * 100;
            pct = Math.max(0, Math.min(100, pct));
            handle.style.left = pct + '%';
            afterImg.style.clipPath = `inset(0 0 0 ${pct}%)`;
        };

        const start = (e) => { dragging = true; card.style.cursor = 'ew-resize'; };
        const end = () => { dragging = false; card.style.cursor = ''; };
        const move = (e) => {
            if (!dragging) return;
            const clientX = e.touches ? e.touches[0].clientX : e.clientX;
            setPosition(clientX);
        };

        handle.addEventListener('mousedown', start);
        handle.addEventListener('touchstart', start, { passive: true });
        window.addEventListener('mousemove', move);
        window.addEventListener('touchmove', move, { passive: true });
        window.addEventListener('mouseup', end);
        window.addEventListener('touchend', end);

        // Click anywhere on the card also moves the slider there.
        card.addEventListener('click', (e) => {
            if (e.target === handle || handle.contains(e.target)) return;
            setPosition(e.clientX);
        });
    });

    // Generic horizontal scroll-snap carousel: prev/next arrows + synced dot pagination.
    // Expects data-{prefix}-track / -prev / -next / -dots / -card attributes.
    const initCardCarousel = (prefix) => {
        const track = document.querySelector(`[data-${prefix}-track]`);
        if (!track) return;
        const prevBtn = document.querySelector(`[data-${prefix}-prev]`);
        const nextBtn = document.querySelector(`[data-${prefix}-next]`);
        const dotsWrap = document.querySelector(`[data-${prefix}-dots]`);
        const cards = track.querySelectorAll(`[data-${prefix}-card]`);
        if (!cards.length) return;

        const scrollByCard = (dir) => {
            const cardWidth = cards[0].getBoundingClientRect().width || 300;
            track.scrollBy({ left: dir * (cardWidth + 20), behavior: 'smooth' });
        };
        prevBtn?.addEventListener('click', () => scrollByCard(-1));
        nextBtn?.addEventListener('click', () => scrollByCard(1));

        if (dotsWrap) {
            const dots = Array.from(dotsWrap.children);
            dots.forEach((dot, i) => {
                dot.addEventListener('click', () => {
                    cards[i]?.scrollIntoView({ behavior: 'smooth', inline: 'start', block: 'nearest' });
                });
            });
            const updateActiveDot = () => {
                let closestIndex = 0;
                let closestDist = Infinity;
                cards.forEach((c, i) => {
                    const dist = Math.abs(c.getBoundingClientRect().left - track.getBoundingClientRect().left);
                    if (dist < closestDist) { closestDist = dist; closestIndex = i; }
                });
                dots.forEach((d, i) => {
                    d.style.background = i === closestIndex ? '#6c1830' : 'rgba(108,24,48,.25)';
                    d.style.width = i === closestIndex ? '22px' : '8px';
                });
            };
            track.addEventListener('scroll', () => {
                clearTimeout(track._scrollTimer);
                track._scrollTimer = setTimeout(updateActiveDot, 80);
            }, { passive: true });
            updateActiveDot();
        }
    };

    initCardCarousel('compare');

    // --- 10. Certifications & Testimonials Carousels ---
    initCardCarousel('certs');
    initCardCarousel('tests');

});
