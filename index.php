<?php
// Get the GitHub username from the URL (GET parameter)
$username = isset($_GET['username']) ? htmlspecialchars($_GET['username']) : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GitHub Stats Viewer</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f0f0f0;
            min-height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .main-center {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .search-bar {
            display: flex;
            flex-direction: row-reverse;
            align-items: center;
            margin: 0;
            max-width: 250px;
            width: 100%;
            background: #e5e7eb;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            border: 1.5px solid #cbd5e1;
            padding: 0;
            overflow: hidden;
        }
        .search-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            background: #2563eb;
            border-radius: 0 8px 8px 0;
            width: 40px;
            height: 40px;
            margin-left: 2px;
        }
        .search-icon svg {
            width: 20px;
            height: 20px;
            fill: #fff;
        }
        .search-bar input[type="text"] {
            background: transparent;
            border: none;
            outline: none;
            padding: 12px 14px;
            font-size: 1rem;
            flex: 1 1 0;
            border-radius: 8px 0 0 8px;
        }
        .search-bar button {
            width: auto; /* یا اگر می‌خواهی کل ارتفاع را بگیرد height: 40px; */
            min-width: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 20px;
            gap: 4px;
            cursor: pointer;
            border: none;
            background: linear-gradient(90deg, #2563eb 60%, #1e40af 100%);
            color: #fff;
            border-radius: 0 8px 8px 0;
            font-weight: 600;
            font-size: 1rem;
            box-shadow: 0 2px 8px rgba(37,99,235,0.08);
            transition: background 0.2s, box-shadow 0.2s;
        }
        .search-bar button:hover {
            background: linear-gradient(90deg, #1e40af 60%, #2563eb 100%);
            box-shadow: 0 4px 16px rgba(37,99,235,0.13);
        }
        .stats-container {
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
            padding: 0;
        }
        .stats-row {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            margin: 0;
            gap: 0;
        }
        .card {
            width: 100%;
            max-width: 700px;
            min-width: 0;
            margin: 5px auto;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
            padding: 1.2rem 1rem;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .card img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .trophy-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
            padding: 1.2rem 1rem;
            margin: 0 auto 1.5rem auto;
            max-width: 700px;
            overflow: visible;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .trophy-scroll {
            width: 100%;
            overflow-x: auto;
            text-align: center;
            padding-bottom: 0.5rem;
        }
        .trophy-card img {
            min-width: 350px;
            max-width: 100%;
            display: inline-block;
        }
        /* Reduce vertical spacing between dashboard sections */
        .dashboard-section,
        .stats-section,
        .contribution-chart,
        .streak-section,
        .trophy-section {
            margin-bottom: 16px; /* or a value that fits your design */
            padding-bottom: 0;
        }

        /* Optionally, remove extra margin from the last section */
        .trophy-section {
            margin-bottom: 0;
        }

        /* Remove bottom margin from the last card/trophy */
        .stats-container > .card:last-of-type,
        .stats-container > .stats-trophy:last-of-type {
            margin-bottom: 0;
        }

        .profile-search-bar {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 2rem;
            margin-bottom: 2rem;
        }
        .profile-pic-big img {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            box-shadow: 0 2px 12px rgba(0,0,0,0.12);
            border: 4px solid #fff;
            background: #fff;
            object-fit: cover;
        }
        @media (max-width: 700px) {
            .profile-search-bar {
                flex-direction: column;
                gap: 1rem;
            }
            .profile-pic-big img {
                width: 100px;
                height: 100px;
            }
        }

        @media (max-width: 600px) {
            .stats-row {
                flex-direction: column;
                gap: 1rem;
                padding-left: 0;
                padding-right: 0;
            }
            .card,
            .trophy-card {
                max-width: 100vw;
                width: 100%;
                padding: 0.5rem;
                margin: 0;
            }
        }

        .profile-header-box {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 2rem;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            padding: 2rem 2.5rem;
            max-width: 700px; /* match .card */
            margin: 2rem auto 2.5rem auto;
        }
        .profile-pic-square {
            width: 170px;
            height: 170px;
            background: transparent;
            border-radius: 16px;
            box-shadow: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .profile-pic-square img {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            object-fit: cover;
            border: none;
            background: transparent;
        }
        @media (max-width: 700px) {
            .profile-header-box {
                flex-direction: column;
                gap: 1rem;
                padding: 1rem;
            }
            .profile-pic-square {
                width: 110px;
                height: 110px;
            }
            .profile-pic-square img {
                width: 100px;
                height: 100px;
            }
        }
    </style>
</head>
<body>

<?php
// Check if user exists (simple check using GitHub API)
$user_found = false;
if ($username) {
    $github_api = @file_get_contents("https://api.github.com/users/$username", false, stream_context_create([
        'http' => [
            'user_agent' => 'GitHub Stats Viewer'
        ]
    ]));
    if ($github_api && strpos($github_api, '"login"') !== false) {
        $user_found = true;
    }
}
?>

<div class="main-center">
    <h1>GitHub Stats Viewer</h1>
    <?php if (!$username): ?>
        <!-- Use this for all search forms -->
<form method="get" class="search-bar">
    <input type="text" name="username" placeholder="Enter GitHub username" value="<?= $username ?>">
    <button type="submit" aria-label="Search">
        <svg style="margin-right:7px;" viewBox="0 0 24 24" width="18" height="18">
            <circle cx="11" cy="11" r="8" stroke="white" stroke-width="2" fill="none"/>
            <line x1="21" y1="21" x2="16.65" y2="16.65" stroke="white" stroke-width="2" stroke-linecap="round"/>
        </svg>
        <span>جستجو</span>
    </button>
</form>
    <?php elseif (!$user_found): ?>
        <form method="get" class="search-bar" style="margin-bottom:20px;">
            <input type="text" name="username" placeholder="Enter GitHub username" value="<?= $username ?>">
            <button type="submit" aria-label="Search">
                <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8" stroke="white" stroke-width="2" fill="none"/><line x1="21" y1="21" x2="16.65" y2="16.65" stroke="white" stroke-width="2" stroke-linecap="round"/></svg>
            </button>
        </form>
        <div class="card" style="max-width:400px; text-align:center;">
            <img src="https://github-readme-streak-stats.herokuapp.com/?user=" alt="Could not find a user with that name." style="width:100%;max-width:350px;display:block;margin:0 auto;">
        </div>
    <?php endif; ?>
</div>

<?php if ($username && $user_found): ?>
    <div class="card">
        <div class="profile-pic-square">
            <img src="https://github.com/<?= $username ?>.png" alt="GitHub Avatar">
        </div>
        <form method="get" class="search-bar">
            <span class="search-icon">
                <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8" stroke="white" stroke-width="2" fill="none"/><line x1="21" y1="21" x2="16.65" y2="16.65" stroke="white" stroke-width="2" stroke-linecap="round"/></svg>
            </span>
            <input type="text" name="username" placeholder="Enter GitHub username" value="<?= $username ?>">
            <button type="submit" aria-label="Search">
                جستجو
            </button>
        </form>
    </div>
    <div class="stats-container">
        <div class="stats-row">
            <div class="card">
                <img src="https://github-readme-stats.vercel.app/api?username=<?= $username ?>&show_icons=true&theme=default&count_private=true&include_all_commits=true&hide=prs,issues" alt="GitHub Stats">
            </div>
            <div class="card">
                <img src="https://github-readme-stats.vercel.app/api/top-langs/?username=<?= $username ?>&layout=compact&theme=default&langs_count=10" alt="Top Languages">
            </div>
        </div>
        <div class="card">
            <img src="https://ghchart.rshah.org/<?= $username ?>" alt="GitHub Contribution Chart">
        </div>
        <div class="card">
            <img src="https://github-readme-streak-stats.herokuapp.com/?user=<?= $username ?>&theme=default" alt="GitHub Streak Stats">
        </div>
        <div class="card trophy-card">
            <div style="font-weight:bold; font-size:1.1rem; margin-bottom:0.7rem;">GitHub Trophies</div>
            <div class="trophy-scroll">
                <img 
                    src="https://github-profile-trophy.vercel.app/?username=<?= $username ?>&margin-w=10&margin-h=10&column=4&no-bg=true&theme=onestar"
                    alt="GitHub Trophies"
                    style="width:100%;max-width:100%;height:auto;display:block;margin:0 auto;"
                >
            </div>
        </div>
    </div>
<?php endif; ?>

</body>
</html>
