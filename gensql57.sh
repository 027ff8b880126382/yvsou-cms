# Copy and replace: create a new file instead of in-place
sed 's/utf8mb4_0900_ai_ci/utf8mb4_unicode_ci/g' install.sql > install57.sql
 