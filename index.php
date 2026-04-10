<?php
require_once 'includes/config.php';
require_once 'includes/blog-renderer.php';

$page_title = 'Home';
include 'includes/header.php';

// Get profile data from database
$profile = $conn->query("SELECT * FROM profile LIMIT 1")->fetch_assoc();
$name = $profile['name'] ?? 'Portfolio';
$title = $profile['title'] ?? 'Developer';

// Deskripsi hardcoded untuk halaman utama (terlalu panjang untuk dashboard)
$bio = "Saya adalah seorang mahasiswa jurusan Teknik Informatika dan juga seorang teknisi perbaikan mesin hanphone. saya juga aktif di berbagai organisasi kampus";

// Extract first name from full name
$first_name = explode(' ', $name)[0];

// Get featured projects from database
$featured_projects = $conn->query("SELECT * FROM portfolios LIMIT 3")->fetch_all(MYSQLI_ASSOC);

// Get featured blog posts (dengan full content untuk parsing)
$featured_blogs = $conn->query("SELECT * FROM blog_posts WHERE status = 'published' ORDER BY created_at DESC LIMIT 3")->fetch_all(MYSQLI_ASSOC);

// Get skills grouped by category
$skills_result = $conn->query("SELECT * FROM skills ORDER BY proficiency DESC");
$skills_data = $skills_result->fetch_all(MYSQLI_ASSOC);

// Get stats for quick stats section
$total_projects = $conn->query("SELECT COUNT(*) as count FROM portfolios")->fetch_assoc()['count'];
$total_skills = $conn->query("SELECT COUNT(*) as count FROM skills")->fetch_assoc()['count'];
$total_blogs = $conn->query("SELECT COUNT(*) as count FROM blog_posts")->fetch_assoc()['count'];

// Helper function untuk extract gambar dari JSON content
function extractImageFromContent($content) {
    if (is_string($content)) {
        $decoded = json_decode($content, true);
        if (is_array($decoded)) {
            foreach ($decoded as $block) {
                if ($block['type'] === 'image' && !empty($block['content']['url'])) {
                    return $block['content']['url'];
                }
            }
        }
    }
    return null;
}

// Helper function untuk extract teks preview dari JSON content
function extractTextPreview($content, $length = 150) {
    if (is_string($content)) {
        $decoded = json_decode($content, true);
        if (is_array($decoded)) {
            foreach ($decoded as $block) {
                if ($block['type'] === 'paragraph' && !empty($block['content']['text'])) {
                    $text = $block['content']['text'];
                    if (strlen($text) > $length) {
                        return substr($text, 0, $length);
                    }
                    return $text;
                }
            }
        }
    }
    return '';
}
?>

<!-- HERO SECTION -->
<section class="hero animate-fade-in">
    <div class="container">
        <div class="hero-content animate-slide-left">
            <h1 class="hero-title">Hi, Saya <span class="text-primary"><?php echo htmlspecialchars($first_name); ?></span></h1>
            <p class="hero-subtitle"><?php echo htmlspecialchars($title); ?></p>
            <p class="hero-description"><?php echo htmlspecialchars($bio); ?></p>
            
            <div class="hero-buttons">
                <a href="pages/about.php" class="btn btn-primary">Lihat Profil</a>
                <a href="pages/contact.php" class="btn btn-outline">Hubungi Saya</a>
            </div>
        </div>
        
        <div class="hero-visual animate-slide-right">
            <?php if (!empty($profile['profile_picture'])): ?>
                <img src="<?php echo htmlspecialchars(BASE_URL . $profile['profile_picture']); ?>" 
                     alt="<?php echo htmlspecialchars($name); ?>" 
                     class="hero-profile-image" style="animation: float 3s ease-in-out infinite;">
            <?php else: ?>
                <div class="hero-icon">
                    <i class="fas fa-code"></i>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- QUICK STATS -->
<section class="quick-stats magic-bento">
    <div class="container">
        <div class="stats-grid" style="animation: fadeInContent 0.8s ease-out; opacity: 0; animation-fill-mode: forwards;">
            <div class="stat-card" style="animation: fadeInContent 0.6s ease-out 0.1s forwards; opacity: 0;">
                <div class="stat-number"><?php echo $total_projects > 0 ? $total_projects . '+' : '0'; ?></div>
                <div class="stat-label">Proyek</div>
            </div>
            <div class="stat-card" style="animation: fadeInContent 0.6s ease-out 0.2s forwards; opacity: 0;">
                <div class="stat-number"><?php echo $total_blogs > 0 ? $total_blogs . '+' : '0'; ?></div>
                <div class="stat-label">Blog</div>
            </div>
            <div class="stat-card" style="animation: fadeInContent 0.6s ease-out 0.3s forwards; opacity: 0;">
                <div class="stat-number"><?php echo $total_skills > 0 ? $total_skills . '+' : '0'; ?></div>
                <div class="stat-label">Skill Utama</div>
            </div>
        </div>
    </div>
</section>

<!-- SKILLS SECTION -->
<section class="skills-section">
    <div class="container">
        <h2 class="section-title animate-slide-up">Kemampuan</h2>
        
        <div class="skills-grid">
            <?php foreach ($skills_data as $index => $skill): ?>
                <div class="skill-item" style="animation: fadeInContent 0.5s ease-out <?php echo ($index * 0.08); ?>s forwards; opacity: 0;">
                    <div class="skill-header">
                        <span><?php echo htmlspecialchars($skill['name']); ?></span>
                        <span><?php echo intval($skill['proficiency']); ?>%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="skill-progress" style="--skill-width: <?php echo intval($skill['proficiency']); ?>%"></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- FEATURED PROJECTS -->
<section class="featured-projects">
    <div class="container">
        <h2 class="section-title animate-slide-up">Proyek Terbaru</h2>
        
        <div class="portfolio-grid">
            <?php if (!empty($featured_projects)): ?>
                <?php foreach ($featured_projects as $project): ?>
                    <article class="portfolio-card">
                        <div class="portfolio-image">
                            <?php if (!empty($project['image'])): ?>
                                <img src="<?php echo BASE_URL . htmlspecialchars($project['image']); ?>" alt="<?php echo htmlspecialchars($project['title']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                            <?php else: ?>
                                <i class="fas fa-project-diagram"></i>
                            <?php endif; ?>
                        </div>
                        <div class="portfolio-content">
                            <h3><?php echo htmlspecialchars($project['title']); ?></h3>
                            <p><?php echo htmlspecialchars(substr($project['description'], 0, 80)) . (strlen($project['description']) > 80 ? '...' : ''); ?></p>
                            <a href="pages/portfolio.php" class="btn-link">Lihat Selengkapnya →</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="grid-column: 1/-1; text-align: center; padding: 2rem; color: #999;">Belum ada proyek yang ditambahkan.</p>
            <?php endif; ?>
        </div>
        
        <div class="text-center mt-40 animate-scale-in">
            <a href="pages/portfolio.php" class="btn btn-primary">Lihat Semua Proyek</a>
        </div>
    </div>
</section>

<!-- FEATURED BLOG POSTS -->
<section class="blog-section">
    <div class="container">
        <h2 class="section-title animate-slide-up">Blog & Artikel Terbaru</h2>
        
        <div class="blog-grid">
            <?php if (!empty($featured_blogs)): ?>
                <?php foreach ($featured_blogs as $blog): 
                    $image = extractImageFromContent($blog['content']);
                    if (empty($image) && !empty($blog['featured_image'])) {
                        $image = $blog['featured_image'];
                    }
                    if (empty($image) && !empty($blog['image'])) {
                        $image = $blog['image'];
                    }
                    
                    $description = !empty($blog['description']) 
                        ? $blog['description'] 
                        : extractTextPreview($blog['content'], 150);
                ?>
                    <article class="blog-card">
                        <div class="blog-image">
                            <?php if (!empty($image)): ?>
                                <img src="<?php echo htmlspecialchars($image); ?>" 
                                     alt="<?php echo htmlspecialchars($blog['title']); ?>"
                                     onerror="this.style.display='none'; this.parentElement.classList.add('no-image');">
                            <?php endif; ?>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" style="width: 80%; height: 80%; <?php echo !empty($image) ? 'display: none;' : ''; ?>" class="placeholder-icon">
                                <circle cx="100" cy="100" r="80" fill="rgba(59, 130, 246, 0.2)" stroke="#3b82f6" stroke-width="2"/>
                                <rect x="60" y="70" width="80" height="16" fill="#3b82f6" rx="2"/>
                                <rect x="60" y="95" width="80" height="4" fill="#3b82f6" rx="1"/>
                                <rect x="60" y="105" width="80" height="4" fill="#3b82f6" rx="1"/>
                                <rect x="60" y="115" width="80" height="4" fill="#3b82f6" rx="1"/>
                            </svg>
                        </div>
                        <div class="blog-content">
                            <span class="blog-category"><?php echo htmlspecialchars($blog['category']); ?></span>
                            <h3 class="blog-title"><?php echo htmlspecialchars($blog['title']); ?></h3>
                            <p class="blog-desc"><?php echo htmlspecialchars($description); ?></p>
                            <div class="blog-meta">
                                <span><?php echo date('d M Y', strtotime($blog['created_at'])); ?></span>
                                <a href="pages/blog-detail.php?id=<?php echo $blog['id']; ?>" class="btn-link">Baca Selengkapnya →</a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="grid-column: 1/-1; text-align: center; padding: 2rem; color: #999;">Belum ada artikel yang ditambahkan.</p>
            <?php endif; ?>
        </div>
        
        <div class="text-center mt-40 animate-scale-in">
            <a href="pages/blog.php" class="btn btn-primary">Lihat Semua Artikel</a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

<script>
    // Intersection Observer untuk animasi saat scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.animation = getComputedStyle(entry.target).animation || 'slideInUp 0.8s ease-out forwards';
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe semua element dengan class animate
    document.querySelectorAll('[class*="animate-"]').forEach(el => {
        observer.observe(el);
    });

    // Intersection Observer untuk skill progress animation
    const skillObserverOptions = {
        threshold: 0.3,
        rootMargin: '0px 0px -100px 0px'
    };

    const skillObserver = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate');
                skillObserver.unobserve(entry.target);
            }
        });
    }, skillObserverOptions);

    // Observe semua skill-progress elements
    document.querySelectorAll('.skill-progress').forEach(el => {
        skillObserver.observe(el);
    });
</script>
