
        function validateForm() {
            const name = document.getElementById("name").value.trim();
            const email = document.getElementById("email").value.trim();
            const phone = document.getElementById("phone").value.trim();
            const fromDate = new Date(document.getElementById("fromDate").value);
            const toDate = new Date(document.getElementById("toDate").value);
            const noOfMember = parseInt(document.getElementById("noOfMember").value);

            const namePattern = /^[A-Za-z\s]+$/;
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const phonePattern = /^\d{1,10}$/;

            if (!namePattern.test(name)) {
                alert("Please enter a valid name with only letters and spaces.");
                return false;
            }

            if (!emailPattern.test(email)) {
                alert("Please enter a valid email address.");
                return false;
            }

            if (!phonePattern.test(phone) || phone.charAt(0) === '0') {
                alert("Please enter a valid phone number (up to 10 digits and should not start with zero).");
                return false;
            }

            const currentDate = new Date();
            const maxDate = new Date();
            maxDate.setDate(maxDate.getDate() + 20);

            if (fromDate < currentDate) {
                alert("From date should be greater than or equal to the current date.");
                return false;
            }

            if (toDate > maxDate) {
                alert("To date should be within the next 20 days from the current date.");
                return false;
            }

            if (toDate < fromDate) {
                alert("To date should be equal to or later than the from date.");
                return false;
            }

            if (!Number.isInteger(noOfMember) || noOfMember <= 0 || noOfMember >= 20) {
                alert("Please enter a valid number of members (a positive integer less than 20).");
                return false;
            }

            return true;
        }

        document.getElementById("myForm").addEventListener("submit", function(event) {
            if (!validateForm()) {
                event.preventDefault();
            }
        });

        // Add reset functionality to the Reset button
        const resetButton = document.querySelector(".reset");
        resetButton.addEventListener("click", function() {
            document.getElementById("myForm").reset();
        });
