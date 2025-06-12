import os
import requests
import csv 
from datetime import datetime, timezone

TOKEN = os.getenv("GH_TOKEN")
REPO = "yvsoucom/yvsou-cms"  # ← Change this
HEADERS = {"Authorization": f"token {TOKEN}"}
BASE = "https://api.github.com/repos/" + REPO

def fetch_json(url):
    r = requests.get(url, headers=HEADERS)
    r.raise_for_status()
    return r.json()

def append_csv(file, fieldnames, row):
    exists = os.path.exists(file)
    with open(file, 'a', newline='') as f:
        writer = csv.DictWriter(f, fieldnames=fieldnames)
        if not exists:
            writer.writeheader()
        writer.writerow(row)

 
today = datetime.now(timezone.utc).strftime("%Y-%m-%d")


# Clone stats
clones = fetch_json(BASE + "/traffic/clones")

import os

# Get the directory where this script lives (docs/)
BASE_DIR = os.path.dirname(os.path.abspath(__file__))

metrics_dir = os.path.join(BASE_DIR, "metrics")
os.makedirs(metrics_dir, exist_ok=True)

clone_stats_path = os.path.join(metrics_dir, "clone-stats.csv")
repo_stats_path = os.path.join(metrics_dir, "repo-stats.csv")

# Then use these paths when saving:
append_csv(clone_stats_path, ["date", "clones", "unique_cloners"], {
    "date": today,
    "clones": clones["count"],
    "unique_cloners": clones["uniques"]
})

repo = fetch_json(BASE)
append_csv(repo_stats_path, ["date", "stars", "forks", "watchers"], {
    "date": today,
    "stars": repo["stargazers_count"],
    "forks": repo["forks_count"],
    "watchers": repo["subscribers_count"]
})


 