from pathlib import Path
path = Path(r"resources/views/topics/show.blade.php")
text = path.read_text()
old_variants = [
    "            @php\n                $renderedSrcdoc = str_replace(['&', '\"'], ['&amp;', '&quot;'], $rendered);\n            @endphp\n\n",
    "            @php\r\n                $renderedSrcdoc = str_replace(['&', '\"'], ['&amp;', '&quot;'], $rendered);\r\n            @endphp\r\n\r\n",
    "            @php\n                $renderedSrcdoc = str_replace(['&', '"'], ['&amp;', '&quot;'], $rendered);\n            @endphp\n\n",
    "            @php\r\n                $renderedSrcdoc = str_replace(['&', '"'], ['&amp;', '&quot;'], $rendered);\r\n            @endphp\r\n\r\n",
]
new = """            @php
                $renderedSrcdoc = str_replace(['&', '"'], ['&amp;', '&quot;'], $rendered);
            @endphp

"""
for old in old_variants:
    if old in text:
        text = text.replace(old, new)
        break
text = text.replace("['&', '\"']", "['&', '\"']")
# After replacement, ensure we remove backslashes before double quotes inside the str_replace call
text = text.replace("['&', '\"'], ['&amp;', '&quot;']", "['&', '"], ['&amp;', '&quot;']")
path.write_text(text)
