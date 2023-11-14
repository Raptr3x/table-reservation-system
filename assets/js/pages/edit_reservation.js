$(document).ready(function() {
    // Variable to store the previous value
    var prevValue;

    // Attach event handler for input changes
    $('input[type="number"]').on('input', function() {
        // Store the current value
        var currentValue = $(this).val();

        // Check if the value is less than 1 or empty
        if (currentValue !== '' && (isNaN(currentValue) || currentValue < 1)) {
            // If so, set it back to the previous value
            $(this).val(prevValue);
        } else {
            // Otherwise, update the previous value
            prevValue = currentValue;
        }
    });

    // Attach event handler for blur
    $('input[type="number"]').on('blur', function() {
        // If the value is empty, set it to 1
        if ($(this).val() === '') {
            $(this).val(1);
        }
    });
});