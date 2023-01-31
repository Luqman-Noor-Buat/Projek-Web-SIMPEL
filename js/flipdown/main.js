document.addEventListener('DOMContentLoaded', () => {
  // Set up FlipDown
  var flipdown = new FlipDown(timeStart, {
    headings: ['Hari', 'Jam', 'Menit', 'Detik'],
    theme: 'light'
  })

    // Start the countdown
    .start()

    // Do something when the countdown ends
    .ifEnded(() => {
      
    });
});
