function dropCourse(courseId) {
    if (confirm("Are you sure you want to drop this course?")) {
        fetch('drop_course.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'course_id=' + encodeURIComponent(courseId)
        })
        .then(response => response.text())
        .then(data => {
            alert(data); // Show the response message
            location.reload(); // Reload the page to reflect changes
        })
        .catch(error => {
            console.error('Error:', error);
            alert("An error occurred while dropping the course.");
        });
    }
}
