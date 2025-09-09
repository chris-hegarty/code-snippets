
//Some checks to make sure everything is loaded:
if (document.readyState === 'loading') {  // If loading hasn't finished yet:
  document.addEventListener('DOMContentLoaded', initializeDialog);
} else {  // `DOMContentLoaded` has already fired
  initializeDialog();
}

function initializeDialog() {
  //check for session storage
  if (sessionStorage.getItem('dialogShown') !== 'true') {
    //wait 7 seconds before dialog appears.
    setTimeout(() => {
      document.getElementById('survey').show();
      //set session storage
      sessionStorage.setItem('dialogShown', 'true');
    }, 7000);
  }

  // Close the dialog when the ESC key is pressed
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      document.getElementById('survey').close();
    }
  });
}



