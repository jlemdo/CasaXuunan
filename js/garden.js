/**
 * Xuunan Garden - Interactive Botanical Experience
 * Casa Xuunan - Valladolid, Yucatan
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize locked/unlocked plant states
    initPlantLockStates();

    // Initialize progress tracking
    initProgressTracking();

    // Initialize discovered plants indicators
    initDiscoveredIndicators();

    // Initialize animations
    initAnimations();

    // Handle plant card clicks
    initPlantCardClicks();
});

/**
 * Progress Tracking System
 * Tracks how many plants the visitor has discovered
 */
function initProgressTracking() {
    const progressFill = document.getElementById('progress-fill');
    const progressText = document.getElementById('progress-text');
    const badges = document.querySelectorAll('.badge-item');

    if (!progressFill || !progressText) return;

    // Get UNLOCKED plants from localStorage (not just discovered)
    let unlocked = JSON.parse(localStorage.getItem('xuunan_garden_unlocked') || '[]');
    const totalPlants = window.GARDEN_DATA ? window.GARDEN_DATA.totalPlants : 100;
    const unlockedCount = unlocked.length;
    const percentage = Math.min((unlockedCount / totalPlants) * 100, 100);

    // Animate progress bar
    setTimeout(function() {
        progressFill.style.width = percentage + '%';
    }, 500);

    // Update text
    const plantsText = window.GARDEN_DATA ? window.GARDEN_DATA.translations.plants_discovered : 'plants discovered';
    progressText.textContent = unlockedCount + ' / ' + totalPlants + ' ' + plantsText;

    // Track unlocked badges count
    let unlockedBadgesCount = 0;

    // Unlock badges based on progress
    badges.forEach(function(badge, index) {
        const threshold = parseInt(badge.getAttribute('data-unlock')) || 0;
        if (unlockedCount >= threshold) {
            badge.classList.remove('locked');
            badge.classList.add('unlocked');
            unlockedBadgesCount = index + 1; // 1 = Explorer, 2 = Botanist, 3 = Expert, 4 = Master
        }
    });

    // Initialize CTA share section based on badges unlocked
    initCtaShareSection(unlockedBadgesCount);
}

/**
 * Initialize CTA Share Section based on user's rank
 * Badge 1 (Explorer): Unlock WhatsApp
 * Badge 2 (Botanist): Unlock Facebook
 * Badge 3 (Expert): Unlock Instagram
 * Badge 4 (Master): All unlocked
 */
function initCtaShareSection(unlockedBadgesCount) {
    const ctaSection = document.getElementById('garden-cta');
    const ctaLockedOverlay = document.getElementById('cta-locked-overlay');

    if (!ctaSection) return;

    // If user has at least Explorer badge, unlock the section
    if (unlockedBadgesCount >= 1) {
        ctaSection.classList.add('unlocked');
        if (ctaLockedOverlay) {
            ctaLockedOverlay.style.display = 'none';
        }
    } else {
        ctaSection.classList.remove('unlocked');
        if (ctaLockedOverlay) {
            ctaLockedOverlay.style.display = 'flex';
        }
    }

    // Handle individual social buttons based on badge level
    document.querySelectorAll('.social-btn').forEach(function(btn) {
        const requiredBadge = parseInt(btn.getAttribute('data-badge')) || 1;

        if (unlockedBadgesCount >= requiredBadge) {
            btn.classList.add('unlocked');
            btn.classList.remove('locked');
        } else {
            btn.classList.add('locked');
            btn.classList.remove('unlocked');

            // Prevent click on locked buttons
            btn.addEventListener('click', function(e) {
                if (this.classList.contains('locked')) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            });
        }
    });
}

/**
 * Show discovered indicators on plant cards
 * Now based on UNLOCKED plants, not just discovered
 */
function initDiscoveredIndicators() {
    // This is now handled by initPlantLockStates()
    // Keeping for backward compatibility
    let unlocked = JSON.parse(localStorage.getItem('xuunan_garden_unlocked') || '[]');

    unlocked.forEach(function(plantId) {
        // Add discovered class to the card
        const card = document.querySelector('[data-plant-id="' + plantId + '"]');
        if (card) {
            card.classList.add('discovered');
        }
    });
}

/**
 * Initialize scroll animations
 */
function initAnimations() {
    // Animate stats on scroll
    const stats = document.querySelectorAll('.stat-number[data-count]');

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    stats.forEach(function(stat) {
        observer.observe(stat);
    });

    // Animate plant cards on scroll
    const cards = document.querySelectorAll('.plant-card');
    const cardObserver = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry, index) {
            if (entry.isIntersecting) {
                setTimeout(function() {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, index * 50);
                cardObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    cards.forEach(function(card) {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'all 0.5s ease';
        cardObserver.observe(card);
    });
}

/**
 * Animate counter from 0 to target value
 */
function animateCounter(element) {
    const target = parseInt(element.getAttribute('data-count'));
    if (!target) return;

    const duration = 2000;
    const step = target / (duration / 16);
    let current = 0;

    const timer = setInterval(function() {
        current += step;
        if (current >= target) {
            current = target;
            clearInterval(timer);
            element.textContent = target;
        } else {
            element.textContent = Math.floor(current);
        }
    }, 16);
}

/**
 * Share functionality for plant pages
 */
function sharePlant(platform) {
    const url = window.location.href;
    const titleEl = document.querySelector('.plant-names h1');
    const title = titleEl ? titleEl.textContent : 'Xuunan Garden';

    const shareUrls = {
        whatsapp: 'https://wa.me/?text=' + encodeURIComponent(title + ' - ' + url),
        facebook: 'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(url),
        twitter: 'https://twitter.com/intent/tweet?url=' + encodeURIComponent(url) + '&text=' + encodeURIComponent(title)
    };

    if (shareUrls[platform]) {
        window.open(shareUrls[platform], '_blank', 'width=600,height=400');
    }
}

/**
 * Copy link to clipboard
 */
function copyPlantLink() {
    const url = window.location.href;

    if (navigator.clipboard) {
        navigator.clipboard.writeText(url).then(function() {
            showToast('Link copied!');
        });
    } else {
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = url;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        showToast('Link copied!');
    }
}

/**
 * Show toast notification
 */
function showToast(message) {
    // Check if toast already exists
    let existingToast = document.querySelector('.plant-discovered-toast');
    if (existingToast) {
        existingToast.remove();
    }

    const toast = document.createElement('div');
    toast.className = 'plant-discovered-toast show';
    toast.innerHTML = '<i class="fa fa-check-circle"></i><span>' + message + '</span>';
    document.body.appendChild(toast);

    setTimeout(function() {
        toast.classList.remove('show');
        setTimeout(function() {
            if (toast.parentNode) {
                document.body.removeChild(toast);
            }
        }, 500);
    }, 2000);
}

/**
 * Smooth scroll to section
 */
function scrollToSection(sectionId) {
    const section = document.getElementById(sectionId);
    if (section) {
        section.scrollIntoView({ behavior: 'smooth' });
    }
}

/**
 * Mark plant as discovered (called from plant.php)
 */
function markPlantAsDiscovered(plantId) {
    let discovered = JSON.parse(localStorage.getItem('xuunan_garden_discovered') || '[]');

    if (!discovered.includes(plantId)) {
        discovered.push(plantId);
        localStorage.setItem('xuunan_garden_discovered', JSON.stringify(discovered));
        return true; // New discovery
    }
    return false; // Already discovered
}

/**
 * Get discovery stats
 */
function getDiscoveryStats() {
    let discovered = JSON.parse(localStorage.getItem('xuunan_garden_discovered') || '[]');
    return {
        count: discovered.length,
        plants: discovered
    };
}

/**
 * Reset progress (for testing)
 */
function resetGardenProgress() {
    localStorage.removeItem('xuunan_garden_discovered');
    localStorage.removeItem('xuunan_garden_unlocked');
    location.reload();
}

/**
 * Initialize plant lock states from localStorage
 * Plants are LOCKED by default, only unlocked via QR code
 */
function initPlantLockStates() {
    let unlocked = JSON.parse(localStorage.getItem('xuunan_garden_unlocked') || '[]');

    // For each plant card, check if it's unlocked
    document.querySelectorAll('.plant-card').forEach(function(card) {
        const plantId = card.getAttribute('data-plant-id');

        if (unlocked.includes(plantId)) {
            // Plant is unlocked - update UI
            card.classList.remove('locked');
            card.classList.add('unlocked');

            // Hide lock overlay
            const lockOverlay = card.querySelector('.plant-card-lock-overlay');
            if (lockOverlay) {
                lockOverlay.style.display = 'none';
            }

            // Show unlocked badge
            const unlockedBadge = card.querySelector('.plant-card-unlocked-badge');
            if (unlockedBadge) {
                unlockedBadge.style.display = 'flex';
            }
        }
    });

    // Handle featured plant lock state
    const featuredPlant = document.getElementById('featured-plant');
    if (featuredPlant) {
        const featuredId = featuredPlant.getAttribute('data-plant-id');
        if (unlocked.includes(featuredId)) {
            featuredPlant.classList.remove('locked');
            featuredPlant.classList.add('unlocked');
        } else {
            featuredPlant.classList.add('locked');
            featuredPlant.classList.remove('unlocked');
        }
    }

    // Handle featured button click
    const featuredBtn = document.querySelector('.featured-btn');
    if (featuredBtn) {
        featuredBtn.addEventListener('click', function(e) {
            const plantId = this.getAttribute('data-plant-id');
            if (!unlocked.includes(plantId)) {
                e.preventDefault();
                // Show shake animation on parent
                const parent = document.getElementById('featured-plant');
                if (parent) {
                    parent.classList.add('shake');
                    setTimeout(function() {
                        parent.classList.remove('shake');
                    }, 500);
                }
            }
        });
    }
}

/**
 * Handle plant card clicks
 * Only allow navigation to unlocked plants
 */
function initPlantCardClicks() {
    document.querySelectorAll('.plant-card').forEach(function(card) {
        card.addEventListener('click', function(e) {
            const plantId = this.getAttribute('data-plant-id');
            let unlocked = JSON.parse(localStorage.getItem('xuunan_garden_unlocked') || '[]');

            if (unlocked.includes(plantId)) {
                // Plant is unlocked - navigate to detail page
                window.location.href = 'plant.php?id=' + plantId;
            } else {
                // Plant is locked - show message or do nothing
                e.preventDefault();

                // Optional: shake animation to indicate locked
                this.classList.add('shake');
                setTimeout(function() {
                    card.classList.remove('shake');
                }, 500);
            }
        });

        // Add cursor pointer for unlocked, default for locked
        const plantId = card.getAttribute('data-plant-id');
        let unlocked = JSON.parse(localStorage.getItem('xuunan_garden_unlocked') || '[]');

        if (unlocked.includes(plantId)) {
            card.style.cursor = 'pointer';
        } else {
            card.style.cursor = 'default';
        }
    });
}

/**
 * Unlock a plant by code (called from QR scan URL)
 * Returns true if unlocked successfully, false otherwise
 */
function unlockPlant(plantId, unlockCode) {
    // This function is called from plant.php when user scans QR
    // The validation is done server-side, this just updates localStorage
    let unlocked = JSON.parse(localStorage.getItem('xuunan_garden_unlocked') || '[]');

    if (!unlocked.includes(plantId)) {
        unlocked.push(plantId);
        localStorage.setItem('xuunan_garden_unlocked', JSON.stringify(unlocked));

        // Also mark as discovered
        markPlantAsDiscovered(plantId);

        return true;
    }
    return false;
}

/**
 * Check if a plant is unlocked
 */
function isPlantUnlocked(plantId) {
    let unlocked = JSON.parse(localStorage.getItem('xuunan_garden_unlocked') || '[]');
    return unlocked.includes(plantId);
}

/**
 * Get unlock stats
 */
function getUnlockStats() {
    let unlocked = JSON.parse(localStorage.getItem('xuunan_garden_unlocked') || '[]');
    return {
        count: unlocked.length,
        plants: unlocked
    };
}
