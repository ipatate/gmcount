## Plugin for increment number of reader for page entry

I created this plugin for page blog. If you want display reader for article.


### for use:

- increment entry page

    ```
    {% set count = craft.gmcount.increment(entry.id) %}
    ```

- display count for entry

    ```
    {{ craft.gmcount.count(entry.id) }}
    ```

- get entry by section (for blog by exemple)
    ```
    {% set entries = craft.gmcount.entriesBySection(entry.sectionId, [limit = 5]) %}
    ```

- display entry

  ```
  {% for entrie in entries %}
    {{ entrie.title }}
  {% endfor %}
  ```