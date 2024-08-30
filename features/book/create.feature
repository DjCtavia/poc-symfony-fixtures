Feature: Creating books

  Scenario: Creating a book with valid data
    When I send a "POST" request to "/api/v1/book" with body:
        """
        {
            "name": "The Lord of the Rings",
            "isbn": "0-1234-5678-9"
        }
        """
    Then print last response