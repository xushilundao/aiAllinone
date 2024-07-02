import requests
from bs4 import BeautifulSoup
from datetime import datetime
import re
import json
import os

def analyze_github_trends():
    url = "https://github.com/trending"
    response = requests.get(url)
    soup = BeautifulSoup(response.text, 'html.parser')
    
    trends = []
    for repo in soup.select('article.Box-row'):
        name = repo.select_one('h2 a').text.strip()
        description = repo.select_one('p')
        description = description.text.strip() if description else "No description"
        
        industry = "Technology"  # 默认行业
        if "machine learning" in description.lower() or "ai" in description.lower():
            industry = "Artificial Intelligence"
        elif "web" in description.lower() or "frontend" in description.lower():
            industry = "Web Development"
        
        stars_element = repo.select_one('a.Link--muted')
        total_stars = int(stars_element.text.strip().replace(',', '')) if stars_element else 0
        
        stars_today_element = repo.select_one('span.d-inline-block.float-sm-right')
        stars_today = re.search(r'(\d+) stars today', stars_today_element.text) if stars_today_element else None
        stars_today = int(stars_today.group(1)) if stars_today else 0
        
        trends.append({
            'name': name,
            'description': description,
            'industry': industry,
            'total_stars': total_stars,
            'stars_today': stars_today
        })
    
    return trends

def load_history():
    if os.path.exists('star_history.json'):
        with open('star_history.json', 'r') as f:
            return json.load(f)
    return {}

def save_history(history):
    with open('star_history.json', 'w') as f:
        json.dump(history, f)

def calculate_velocity(trends, history):
    today = datetime.now().strftime('%Y-%m-%d')
    yesterday = max(history.keys()) if history else None
    
    for trend in trends:
        repo_name = trend['name']
        if repo_name in history.get(yesterday, {}):
            yesterday_stars = history[yesterday][repo_name]
            velocity = trend['total_stars'] - yesterday_stars
            trend['star_velocity'] = velocity
        else:
            trend['star_velocity'] = "N/A"
    
    # 更新历史
    history[today] = {trend['name']: trend['total_stars'] for trend in trends}
    save_history(history)
    
    return trends

def update_html(trends):
    html_content = f"""
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>GitHub Trends</title>
        <style>
            table {{ border-collapse: collapse; width: 100%; }}
            th, td {{ border: 1px solid black; padding: 8px; text-align: left; }}
            th {{ background-color: #f2f2f2; }}
        </style>
    </head>
    <body>
        <h1>GitHub Trends - {datetime.now().strftime('%Y-%m-%d')}</h1>
        <table>
            <tr>
                <th>Repository</th>
                <th>Industry/Usage</th>
                <th>Description</th>
                <th>Total Stars</th>
                <th>Stars Today</th>
                <th>Star Velocity</th>
            </tr>
    """
    
    for trend in trends:
        html_content += f"""
            <tr>
                <td>{trend['name']}</td>
                <td>{trend['industry']}</td>
                <td>{trend['description']}</td>
                <td>{trend['total_stars']}</td>
                <td>{trend['stars_today']}</td>
                <td>{trend['star_velocity']}</td>
            </tr>
        """
    
    html_content += """
        </table>
    </body>
    </html>
    """
    
    with open('ghTrend.php', 'w', encoding='utf-8') as f:
        f.write(html_content)

def main():
    try:
        trends = analyze_github_trends()
        history = load_history()
        trends = calculate_velocity(trends, history)
        update_html(trends)
        print(f"Updated ghTrend.php at {datetime.now()}")
    except Exception as e:
        print(f"Error occurred: {e}")

if __name__ == "__main__":
    main()
