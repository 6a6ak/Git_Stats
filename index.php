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
            text-align: center;
            padding: 2rem;
            background-color: #f0f0f0;
        }
        .search-bar {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 1.5rem auto 0 auto;
            max-width: 400px;
            width: 100%;
        }
        .search-bar input[type="text"] {
            padding: 10px 14px;
            font-size: 1rem;
            border: none;
            border-radius: 6px 0 0 6px;
            width: 100%;
            box-sizing: border-box;
            outline: none;
        }
        .search-bar button {
            padding: 0 18px;
            height: 40px;
            background: #2563eb;
            color: #fff;
            border: none;
            border-radius: 0 6px 6px 0;
            cursor: pointer;
            transition: background 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .search-bar button:hover {
            background: #1e40af;
        }
        .search-bar svg {
            width: 20px;
            height: 20px;
            fill: #fff;
        }
        .stats-heading {
            margin-top: 1.5rem;
            margin-bottom: 1.5rem;
            font-size: 1.3rem;
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
            margin: 0 auto;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
            padding: 1.2rem 1rem;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .stats-wide img,
        .stats-single img {
            width: 100%;
            object-fit: contain;
        }
        .stats-trophy {
            margin: 0 auto 1.5rem auto;
            width: 100%;
            max-width: 700px;
            overflow-x: auto;
            white-space: nowrap;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
            padding: 1.2rem 1rem;
        }
        .stats-trophy img {
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
            padding-bottom: 110;
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

        @media (max-width: 600px) {
            .stats-row {
                flex-direction: column;
                gap: 1rem;
                padding-left: 0;
                padding-right: 0;
            }
            .card,
            .stats-wide,
            .stats-single,
            .stats-trophy {
                max-width: 100vw;
                width: 100%;
                padding: 0.5rem;
                margin: 0;
            }
        }
    </style>
</head>
<body>

<h1>GitHub Stats Viewer</h1>

<form method="get" class="search-bar">
    <input type="text" name="username" placeholder="Enter GitHub username" value="<?= $username ?>">
    <button type="submit" aria-label="Search">
        <!-- Search icon SVG -->
        <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8" stroke="white" stroke-width="2" fill="none"/><line x1="21" y1="21" x2="16.65" y2="16.65" stroke="white" stroke-width="2" stroke-linecap="round"/></svg>
    </button>
</form>

<?php if ($username): ?>
    <div style="margin-top:1.5rem;">
        <img src="https://github.com/<?= $username ?>.png" alt="GitHub Avatar" style="width:96px;height:96px;border-radius:50%;box-shadow:0 2px 8px rgba(0,0,0,0.08);margin-bottom:1rem;">
    </div>
    <div class="stats-heading">
        Stats for <strong><?= $username ?></strong>
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
        <div class="stats-trophy">
            <img src="https://github-profile-trophy.vercel.app/?username=<?= $username ?>&margin-w=10&margin-h=10&row=1&no-bg=true&theme=onestar" alt="GitHub Trophies">
        </div>
    </div>
<?php endif; ?>

</body>
</html>
