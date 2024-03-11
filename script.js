document.addEventListener("DOMContentLoaded", function () {
  // Add event listener to the clear button
  const clearButton = document.getElementById("clear-button-tt");
  if (clearButton) {
    clearButton.addEventListener("click", clearAndReset);
  }
});

function clearAndReset() {
  // Retrieve the patient ID from the URL
  const urlParams = new URLSearchParams(window.location.search);
  const patientId = urlParams.get('showid');

  // Send an AJAX request to delete the row
  fetch('delete_row.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({ patientId: patientId }),
  })
  .then(response => {
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    return response.json();
  })
  .then(data => {
    console.log('Row deleted successfully:', data);
    // Reload the page or update UI as needed
    location.reload(); // Reload the page after deletion
  })
  .catch(error => {
    console.error('There was a problem deleting the row:', error);
  });
}
