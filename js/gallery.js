/**
 * Gallery.js — Dynamic gallery with Hospitable API images + NeuroCaptions
 * Casa Xu'unan B&B Familiar
 */
(async function () {
    var galleryGrid = document.getElementById('carousel-rooms');
    if (!galleryGrid) return;

    var isMobile = window.innerWidth <= 576;
    var DESKTOP_MAX = 15;
    var MOBILE_INITIAL = 4;
    var MOBILE_BATCH = 4;

    // 1. Apply NeuroCaptions to existing static images
    var staticCaptions = galleryGrid.querySelectorAll('.pf_caption');
    staticCaptions.forEach(function (el) {
        if (!el.textContent.trim()) {
            el.textContent = typeof NeuroCaptions !== 'undefined'
                ? NeuroCaptions.getRandomWord()
                : '';
        }
    });

    // 2. Collect existing image URLs to avoid duplicates
    var existingUrls = {};
    galleryGrid.querySelectorAll('img.cover-image').forEach(function (img) {
        var src = img.getAttribute('src');
        if (src) existingUrls[src] = true;
    });

    // 3. Fetch all property IDs
    var allApiImages = [];
    try {
        var propRes = await fetch('api_proxy_secure.php?endpoint=properties');
        if (!propRes.ok) throw new Error('Properties fetch failed');
        var propData = await propRes.json();
        var properties = propData.data || [];

        // 4. Fetch images from all properties in parallel
        var imagePromises = properties.map(function (prop) {
            return fetch('api_proxy_secure.php?endpoint=properties/' + prop.id + '/images')
                .then(function (r) { return r.ok ? r.json() : { data: [] }; })
                .then(function (d) { return d.data || []; })
                .catch(function () { return []; });
        });

        var imageArrays = await Promise.all(imagePromises);
        var rawImages = imageArrays.reduce(function (acc, arr) { return acc.concat(arr); }, []);

        // 5. Filter duplicates against static images
        rawImages.forEach(function (img) {
            if (img.url && !existingUrls[img.url]) {
                allApiImages.push(img);
                existingUrls[img.url] = true;
            }
        });

        // 6. Shuffle (Fisher-Yates)
        for (var i = allApiImages.length - 1; i > 0; i--) {
            var j = Math.floor(Math.random() * (i + 1));
            var temp = allApiImages[i];
            allApiImages[i] = allApiImages[j];
            allApiImages[j] = temp;
        }
    } catch (e) {
        // API failed — gallery works fine with just the 7 static images
        return;
    }

    if (allApiImages.length === 0) return;

    // 7. Determine how many to show
    var displayCount = isMobile ? MOBILE_INITIAL : Math.min(DESKTOP_MAX, allApiImages.length);
    var loadedCount = 0;

    function createGalleryItem(imageObj) {
        var caption = typeof NeuroCaptions !== 'undefined'
            ? NeuroCaptions.getRandomWord()
            : '';

        var item = document.createElement('div');
        item.className = 'item gallery-api-item';
        item.innerHTML =
            '<div class="picframe">' +
                '<a href="' + imageObj.url + '" class="image-popup-gallery">' +
                    '<span class="overlay">' +
                        '<span class="pf_title"><i class="icon_search"></i></span>' +
                        '<span class="pf_caption">' + caption + '</span>' +
                    '</span>' +
                '</a>' +
                '<img src="' + imageObj.url + '" alt="' + caption + '" class="cover-image" loading="lazy">' +
            '</div>';
        return item;
    }

    function appendBatch(count) {
        var end = Math.min(loadedCount + count, allApiImages.length);
        for (var i = loadedCount; i < end; i++) {
            var item = createGalleryItem(allApiImages[i]);
            item.style.opacity = '0';
            galleryGrid.appendChild(item);
            // Animate in
            (function (el) {
                requestAnimationFrame(function () {
                    requestAnimationFrame(function () {
                        el.style.transition = 'opacity 0.4s ease';
                        el.style.opacity = '1';
                    });
                });
            })(item);
        }
        loadedCount = end;
    }

    function reinitLightbox() {
        if (typeof $ !== 'undefined' && $.fn.magnificPopup) {
            $('.image-popup-gallery').magnificPopup({
                type: 'image',
                mainClass: 'mfp-with-zoom mfp-img-mobile',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true
                },
                image: {
                    titleSrc: function (item) {
                        var el = item.el;
                        if (el.find('.pf_caption').length) return el.find('.pf_caption').text();
                        if (typeof NeuroCaptions !== 'undefined') return NeuroCaptions.getRandomWord();
                        return '';
                    }
                }
            });
        }
    }

    // 8. Initial render
    appendBatch(displayCount);
    reinitLightbox();

    // 9. Mobile: show "Load More" button
    if (isMobile && allApiImages.length > MOBILE_INITIAL) {
        var loadMoreContainer = document.getElementById('gallery-load-more');
        var loadMoreBtn = document.getElementById('btn-load-more');

        if (loadMoreContainer && loadMoreBtn) {
            loadMoreContainer.style.display = 'block';

            loadMoreBtn.addEventListener('click', function () {
                appendBatch(MOBILE_BATCH);
                reinitLightbox();

                if (loadedCount >= allApiImages.length) {
                    loadMoreContainer.style.display = 'none';
                }
            });
        }
    }
})();
