import json
import os

skill_dir = r"C:\Users\hariz\.gemini\config\skills\ui-ux-pro-max-skill"

with open(os.path.join(skill_dir, "skill.json"), "r", encoding="utf-8") as f:
    skill_info = json.load(f)

title = skill_info.get("displayName", "UI/UX Pro Max")
description = skill_info.get("description", "")

with open(os.path.join(skill_dir, "src", "ui-ux-pro-max", "templates", "base", "quick-reference.md"), "r", encoding="utf-8") as f:
    quick_ref = f.read()

with open(os.path.join(skill_dir, "src", "ui-ux-pro-max", "templates", "base", "skill-content.md"), "r", encoding="utf-8") as f:
    skill_content = f.read()

skill_content = skill_content.replace("{{TITLE}}", title)
skill_content = skill_content.replace("{{DESCRIPTION}}", description)
skill_content = skill_content.replace("{{QUICK_REFERENCE}}", quick_ref)

yaml_frontmatter = f"""---
name: {skill_info.get("name", "ui-ux-pro-max")}
description: {description}
---

"""

final_content = yaml_frontmatter + skill_content

with open(os.path.join(skill_dir, "SKILL.md"), "w", encoding="utf-8") as f:
    f.write(final_content)

print("SKILL.md created successfully.")
