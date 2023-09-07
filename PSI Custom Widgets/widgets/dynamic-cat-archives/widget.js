jQuery(document).ready(function($) {
    // Access the localized data in JavaScript
    var categoryId = customWidgetData.categoryId;
    var baseUrl = customWidgetData.baseUrl;

    // Reload the page with the selected year and category
    function reloadPageWithYearAndCategory(selectElement) {
        var selectedYear = selectElement.value;
        var newUrl = `${baseUrl}/${selectedYear}/?cat=${categoryId}`;
        window.location.href = newUrl;
    }

    // Attach event listener to the select element
    $('#custom-year-select').on('change', function() {
        reloadPageWithYearAndCategory(this);
    });
});
