<?php
/*
 Template Name: Team Template
*/
get_header();
?>
<?php
// Team Member Loop with Modal and Filtering
$team_members = new WP_Query(array(
    'post_type' => 'team-member',
    'posts_per_page' => -1,
    'post_status' => 'publish'
));

if ($team_members->have_posts()) : ?>

    <!-- Filter Controls -->
    <!-- Filter Controls -->
    <div class="team-filters">
        <button class="filter-btn" data-filter="all">All</button>
        <button class="filter-btn" data-filter=".filter-leadership">Leadership</button>
        <button class="filter-btn" data-filter=".filter-preconstruction">Preconstruction</button>
        <button class="filter-btn" data-filter=".filter-field-operations">Field Operations</button>
        <button class="filter-btn" data-filter=".filter-corporate-communications">Corporate Communications</button>
    </div>

    <!-- Team Members Grid -->
    <div class="team-members-grid" id="mixitup-container">
        <?php while ($team_members->have_posts()) : $team_members->the_post();
            $post_id = get_the_ID();
            $member_title = get_field('title', $post_id);
            $profile_picture = get_field('profile_picture', $post_id);

            // Get the tags/categories for filtering
            $tags = get_the_tags($post_id);
            $filter_classes = '';
            if ($tags) {
                foreach ($tags as $tag) {
                    $filter_classes .= ' filter-' . sanitize_html_class($tag->slug);
                }
            }
        ?>
            <div class="team-member-card mix<?php echo $filter_classes; ?>" data-member-id="<?php echo $post_id; ?>">
                <div class="member-image-container">
                    <div class="member-image">
                        <?php if ($profile_picture) : ?>
                            <img src="<?php echo esc_url($profile_picture['url']); ?>" alt="<?php echo esc_attr($profile_picture['alt']); ?>">
                        <?php endif; ?>
                    </div>
                    <svg class="image-overlay-svg" width="100%" height="100%" viewBox="0 0 350 350" preserveAspectRatio="xMidYMid meet" style="max-width: 100%; height: auto;">
                        <path id="myCircle" d="M 175,50 A 125,125 0 1,1 174.99,50" fill="none" stroke="black" stroke-width="2" />
                        <text font-family="Arial, sans-serif" font-size="16" fill="black">
                            <textPath href="#myCircle" startOffset="75%" text-anchor="middle">
                                <?php echo esc_html(get_the_title()); ?>
                            </textPath>
                        </text>
                    </svg>
                </div>
                <div class="circle-container">
                    <!-- Replace src with your actual image path -->
                    <img src="https://placehold.co/350"
                        alt="Person's Photo"
                        class="circle-image">

                    <svg class="text-overlay" viewBox="-100 -100 550 550" preserveAspectRatio="xMidYMid meet">
                        <!-- Invisible circle path for text to follow -->
                        <path id="textCircle"
                            d="M 175,-20 A 195,195 0 1,1 174.99,-20"
                            fill="none"
                            stroke="none" />

                        <text class="circle-text">
                            <textPath href="#textCircle" startOffset="75%" text-anchor="middle">
                                John Smith • Photographer • Artist
                            </textPath>
                        </text>
                    </svg>
                </div>

                <!-- Example with different container sizes -->
                <div style="width: 200px; margin: 2rem auto; border: 2px solid #ccc; padding: 1rem;">
                    <h3 style="text-align: center; margin-top: 0;">Small Container (200px)</h3>
                    <div class="circle-container">
                        <img src="https://placehold.co/350"
                            alt="Person's Photo"
                            class="circle-image">

                        <svg class="text-overlay" viewBox="-100 -100 550 550" preserveAspectRatio="xMidYMid meet">
                            <path id="textCircle2"
                                d="M 175,-20 A 195,195 0 1,1 174.99,-20"
                                fill="none"
                                stroke="none" />

                            <text class="circle-text">
                                <textPath href="#textCircle2" startOffset="75%" text-anchor="middle">
                                    Jane Doe • Designer
                                </textPath>
                            </text>
                        </svg>
                    </div>
                </div>

                <div style="width: 500px; margin: 2rem auto; border: 2px solid #ccc; padding: 1rem;">
                    <h3 style="text-align: center; margin-top: 0;">Large Container (500px)</h3>
                    <div class="circle-container">
                        <img src="https://placehold.co/350"
                            alt="Person's Photo"
                            class="circle-image">

                        <svg class="text-overlay" viewBox="-100 -100 550 550" preserveAspectRatio="xMidYMid meet">
                            <path id="textCircle3"
                                d="M 250,10 A 240,240 0 1,1 249.99,10"
                                fill="none"
                                stroke="none" />

                            <text class="circle-text">
                                <textPath href="#textCircle3" startOffset="75%" text-anchor="middle">
                                    Alex Johnson • Creative Director • Innovator
                                </textPath>
                            </text>
                        </svg>
                    </div>
                </div>
                <p class="member-title"><?php echo esc_html($member_title); ?></p>
            </div>
        <?php endwhile; ?>
    </div>

    <!-- Modal Structure -->
    <div id="team-member-modal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <button class="modal-close">&times;</button>

            <div class="modal-header">
                <div class="modal-profile-image">
                    <img id="modal-profile-pic" src="" alt="">
                </div>
                <div class="modal-basic-info">
                    <h2 id="modal-name"></h2>
                    <p id="modal-title"></p>
                    <a id="modal-linkedin" href="" target="_blank" style="display: none;">LinkedIn Profile</a>
                </div>
            </div>

            <!-- Callouts Section -->
            <div class="modal-callouts">
                <h3>Callouts</h3>
                <div id="modal-callouts-content"></div>
            </div>

            <!-- Tab Navigation -->
            <div class="modal-tabs">
                <button class="tab-button active" data-tab="industry">Industry</button>
                <button class="tab-button" data-tab="personal">Personal</button>
            </div>

            <!-- Tab Content -->
            <div class="tab-content">
                <div id="industry-tab" class="tab-panel active">
                    <div id="industry-info-content"></div>
                </div>
                <div id="personal-tab" class="tab-panel">
                    <div id="personal-info-content"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize MixItUp
            const mixer = mixitup('#mixitup-container', {
                animation: {
                    duration: 600,
                    effects: 'fade translateZ(-100px) stagger(50ms)',
                    easing: 'cubic-bezier(0.25, 0.46, 0.45, 0.94)'
                },
                layout: {
                    allowNestedTargets: false
                },
                selectors: {
                    target: '.mix'
                }
            });

            // Handle filter button clicks
            const filterButtons = document.querySelectorAll('.filter-btn');

            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const filter = this.dataset.filter;

                    // Update active button
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');

                    // Filter with MixItUp
                    mixer.filter(filter);
                });
            });

            // Set initial active state
            document.querySelector('.filter-btn[data-filter="all"]').classList.add('active');

            // Store team member data
            const teamMemberData = {};

            <?php
            // Reset the query and loop through again to get all data for JavaScript
            $team_members->rewind_posts();
            while ($team_members->have_posts()) : $team_members->the_post();
                $post_id = get_the_ID();
                $member_title = get_field('title', $post_id);
                $profile_picture = get_field('profile_picture', $post_id);
                $linkedin_profile = get_field('linkedin_profile', $post_id);
                $callouts = get_field('callouts', $post_id);
                $industry_info = get_field('industry_info', $post_id);
                $personal_info = get_field('personal_info', $post_id);

                // Ensure we have arrays, not false values
                $callouts = $callouts ?: [];
                $industry_info = $industry_info ?: [];
                $personal_info = $personal_info ?: [];
            ?>
                teamMemberData[<?php echo $post_id; ?>] = {
                    name: "<?php echo esc_js(get_the_title()); ?>",
                    title: "<?php echo esc_js($member_title); ?>",
                    profilePicture: {
                        url: "<?php echo $profile_picture ? esc_js($profile_picture['url']) : ''; ?>",
                        alt: "<?php echo $profile_picture ? esc_js($profile_picture['alt']) : ''; ?>"
                    },
                    linkedinProfile: <?php echo json_encode($linkedin_profile ?: null); ?>,
                    callouts: <?php echo json_encode($callouts); ?>,
                    industryInfo: <?php echo json_encode($industry_info); ?>,
                    personalInfo: <?php echo json_encode($personal_info); ?>
                };
            <?php endwhile; ?>

            const modal = document.getElementById('team-member-modal');
            const modalClose = document.querySelector('.modal-close');
            const modalContent = document.querySelector('.modal-content');

            // Open modal when team member is clicked (using event delegation for MixItUp)
            document.getElementById('mixitup-container').addEventListener('click', function(e) {
                const card = e.target.closest('.team-member-card');
                if (card) {
                    const memberId = card.dataset.memberId;
                    const memberData = teamMemberData[memberId];

                    if (memberData) {
                        populateModal(memberData);
                        modal.style.display = 'block';
                        document.body.classList.add('modal-open');
                    }
                }
            });

            // Close modal when clicking close button or overlay
            modal.addEventListener('click', function(e) {
                if (e.target === modal || e.target === modalClose) {
                    closeModal();
                }
            });

            // Prevent modal content clicks from closing modal
            modalContent.addEventListener('click', function(e) {
                e.stopPropagation();
            });

            // Tab switching
            document.querySelectorAll('.tab-button').forEach(button => {
                button.addEventListener('click', function() {
                    const tabName = this.dataset.tab;

                    // Update active tab button
                    document.querySelectorAll('.tab-button').forEach(btn => {
                        btn.classList.remove('active');
                    });
                    this.classList.add('active');

                    // Update active tab panel
                    document.querySelectorAll('.tab-panel').forEach(panel => {
                        panel.classList.remove('active');
                    });
                    document.getElementById(tabName + '-tab').classList.add('active');
                });
            });

            // ESC key to close modal
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeModal();
                }
            });

            function populateModal(memberData) {
                console.log('Member data:', memberData); // Debug line

                // Basic info
                document.getElementById('modal-name').textContent = memberData.name;
                document.getElementById('modal-title').textContent = memberData.title;

                // Profile picture
                const profilePic = document.getElementById('modal-profile-pic');
                if (memberData.profilePicture.url) {
                    profilePic.src = memberData.profilePicture.url;
                    profilePic.alt = memberData.profilePicture.alt;
                }

                // LinkedIn profile
                const linkedinLink = document.getElementById('modal-linkedin');
                if (memberData.linkedinProfile && memberData.linkedinProfile.url) {
                    linkedinLink.href = memberData.linkedinProfile.url;
                    linkedinLink.textContent = memberData.linkedinProfile.title || 'LinkedIn Profile';
                    linkedinLink.target = memberData.linkedinProfile.target || '_blank';
                    linkedinLink.style.display = 'inline-block';
                } else {
                    linkedinLink.style.display = 'none';
                }

                // Callouts
                populateCallouts(memberData.callouts);

                // Industry info
                populateRepeaterContent(memberData.industryInfo, '#industry-info-content');

                // Personal info
                populateRepeaterContent(memberData.personalInfo, '#personal-info-content');
            }

            function populateCallouts(callouts) {
                let calloutsHtml = '';
                console.log('Callouts data:', callouts); // Debug line

                if (callouts && callouts.length > 0) {
                    callouts.forEach(function(callout) {
                        console.log('Processing callout:', callout); // Debug line
                        calloutsHtml += '<div class="callout-item">';

                        if (callout.text_or_icon === 'icon' && callout.icon && callout.icon.url) {
                            calloutsHtml += '<div class="callout-icon"><img src="' + callout.icon.url + '" alt="' + (callout.icon.alt || '') + '"></div>';
                        }

                        if (callout.text) {
                            calloutsHtml += '<div class="callout-text">' + callout.text + '</div>';
                        }

                        if (callout.sub_text) {
                            calloutsHtml += '<div class="callout-subtext">' + callout.sub_text + '</div>';
                        }

                        calloutsHtml += '</div>';
                    });
                }

                document.getElementById('modal-callouts-content').innerHTML = calloutsHtml;
            }

            function populateRepeaterContent(repeaterData, targetSelector) {
                let html = '';
                console.log('Repeater data for ' + targetSelector + ':', repeaterData); // Debug line

                if (repeaterData && repeaterData.length > 0) {
                    repeaterData.forEach(function(item) {
                        console.log('Processing item:', item); // Debug line

                        html += '<div class="repeater-item">';

                        if (item.icon && item.icon.url) {
                            html += '<div class="item-icon"><img src="' + item.icon.url + '" alt="' + (item.icon.alt || '') + '"></div>';
                        }

                        if (item.title) {
                            html += '<h4 class="item-title">' + item.title + '</h4>';
                        }

                        if (item.text) {
                            html += '<div class="item-text">' + item.text + '</div>';
                        }

                        html += '</div>';
                    });
                } else {
                    html = '<p>No information available.</p>';
                }

                const targetElement = document.querySelector(targetSelector);
                if (targetElement) {
                    targetElement.innerHTML = html;
                } else {
                    console.error('Target element not found:', targetSelector);
                }
            }

            function closeModal() {
                modal.style.display = 'none';
                document.body.classList.remove('modal-open');
            }
        });
    </script>

<?php endif;
wp_reset_postdata();
?>
<?php
get_footer();
?>