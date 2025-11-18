class NoticeBoardJs {
    constructor() {
        // Initialization logic, e.g., set up any default values if needed
        this.categoryId = '';
        this.searchQuery = '';
    }

    // Initialize the event listeners for search and filter
    init() {
        // Bind event listeners
        $('#searchBox').on('keyup', () => this.searchNotices());
        $('#filterDropdown').on('change', () => this.filterNotices());
    }

    // Function to filter notices by category
    filterNotices() {
        this.categoryId = $('#filterDropdown').val();
        this.searchQuery = $('#searchBox').val();

        // Trigger AJAX request to get filtered data
        this.fetchNotices(this.categoryId, this.searchQuery);
    }

    // Function to search notices by input text
    searchNotices() {
        this.searchQuery = $('#searchBox').val();
        this.categoryId = $('#filterDropdown').val();

        // Trigger AJAX request to get filtered data
        this.fetchNotices(this.categoryId, this.searchQuery);
    }

    // AJAX function to request filtered notices
    fetchNotices(categoryId = '', searchQuery = '') {
        $.ajax({
            url: '/noticeboard/filter',   // The route where the request will be sent
            type: 'POST',
            data: {
                category_id: categoryId,
                search_query: searchQuery,
                _token: $('meta[name="csrf-token"]').attr('content') // Use CSRF token
            },
            success: (response) => {
                // console.log(response.html);
                // Update the notice board with the filtered data
                $('#noticesContainer').empty().html(response.data);
                $('#noticesContainer_pagination').empty();
            },
            error: (xhr, status, error) => {
                console.error('Error fetching notices:', error);
            }
        });
    }
}

// Instantiate and initialize the NoticeBoardJs class when the DOM is ready
$(document).ready(() => {
    const noticeBoardJs = new NoticeBoardJs();
    noticeBoardJs.init();
});
