<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create a project
        DB::unprepared("
        CREATE PROCEDURE IF NOT EXISTS createProject(IN p_title VARCHAR(255),
                                       IN p_description TEXT,
                                       IN p_image VARCHAR(255),
                                       IN p_owner_id INT,
                                       IN p_status_id INT,
                                       IN p_tags VARCHAR(255))
        BEGIN
            DECLARE project_id INT;
            INSERT INTO projects (title, description, image, owner_id, status_id)
            VALUES (p_title, p_description, p_image, p_owner_id, p_status_id);

            SET project_id = LAST_INSERT_ID();

            INSERT INTO teams (name, personal_team, user_id, project_id)
            VALUES (p_title, 1, p_owner_id, project_id);

            SET p_tags = REPLACE(p_tags, ' ', '');
            SET p_tags = CONCAT(p_tags, ',');
            WHILE LENGTH(p_tags) > 0 DO
                SET @tag = SUBSTRING_INDEX(p_tags, ',', 1);
                INSERT INTO tags (name, project_id)
                VALUES (@tag, project_id);
                SET p_tags = SUBSTRING(p_tags, LENGTH(@tag) + 2);
            END WHILE;
        END
        ");

        // Update a project
        DB::unprepared("
        CREATE PROCEDURE IF NOT EXISTS updateProject(
            IN p_project_id INT,
            IN p_title VARCHAR(255),
            IN p_description TEXT,
            IN p_image VARCHAR(255),
            IN p_status_id INT,
            IN p_new_tags VARCHAR(255)
        )
        BEGIN
            UPDATE projects
            SET
                title = p_title,
                description = p_description,
                image = IF(LENGTH(p_image) > 0, p_image, image),
                status_id = p_status_id
            WHERE id = p_project_id;

            UPDATE teams
            SET name = p_title
            WHERE project_id = p_project_id;

            DELETE FROM tags WHERE project_id = p_project_id;

            SET p_new_tags = REPLACE(p_new_tags, ' ', '');
            SET p_new_tags = CONCAT(p_new_tags, ',');
            WHILE LENGTH(p_new_tags) > 0 DO
                SET @tag = SUBSTRING_INDEX(p_new_tags, ',', 1);
                INSERT INTO tags (name, project_id)
                VALUES (@tag, p_project_id);
                SET p_new_tags = SUBSTRING(p_new_tags, LENGTH(@tag) + 2);
            END WHILE;
        END
    ");

        // Delete a project
        DB::unprepared("
        CREATE PROCEDURE IF NOT EXISTS deleteProject(IN p_project_id INT)
        BEGIN
            DECLARE team_id INT;

            SET team_id = (SELECT id FROM teams WHERE project_id = p_project_id LIMIT 1);

            DELETE FROM tags WHERE project_id = p_project_id;

            DELETE FROM teams WHERE project_id = p_project_id;

            DELETE FROM projects WHERE id = p_project_id;
        END
    ");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
