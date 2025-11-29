$('.approve-btn').on('click', function() {
        var transactionId = $(this).data('transaction-id'); // Uzima ID transakcije

        // Potvrda od strane admina
        if (confirm('Are you sure you want to approve this withdrawal?')) {
            // AJAX zahtev za ažuriranje statusa
            $.ajax({
                url: 'php/approveWithdrawal.php',
                type: 'POST',
                data: { transaction_id: transactionId },
                success: function(response) {
                    location.reload(); 
                },
                error: function(xhr, status, error) {
                    console.log(error);
                    alert('Failed to approve withdrawal');
                }
            });
        }
    });