swagger: "2.0"
info:
  description: "A simple API allowing you to created/read/update/delete strings that may or may not be palindromes."
  version: "1.0.0"
  title: "l8-demo"
  termsOfService: "http://sub.domain.com/terms/"
  contact:
    email: "dev@sub.domain.com"
  license:
    name: "MIT"
    url: "https://opensource.org/licenses/MIT"
host: "{{ request()->getHttpHost().request()->getBaseUrl() }}"
basePath: "/api/v1"
schemes:
  - "https"
  - "http"
paths:
  /palindromes:
    get:
      summary: "Get a collection of palindrome entries"
      description: ""
      operationId: "indexPalindromes"
      consumes:
        - "application/json"
      produces:
        - "application/json"
      parameters:
        - in: "query"
          name: "page"
          description: "Page number"
          type: "integer"
        - in: "query"
          name: "per_page"
          description: "Number of entries per page"
          type: "integer"
      responses:
        "200":
          description: "OK"
    post:
      summary: "Create a new palindrome entry"
      description: ""
      operationId: "createPalindrome"
      consumes:
        - "application/json"
      produces:
        - "application/json"
      parameters:
        - in: "body"
          name: "body"
          description: "Text to evaluate as palindrome or not"
          required: true
          schema:
            $ref: "#/definitions/Palindrome"
      responses:
        "201":
          description: "OK"
        "400":
          description: "Palindrome entry already exists"
  /palindromes/{palindrome}:
    get:
      summary: "Fetch an existing palindrome entry"
      consumes:
        - "application/json"
      produces:
        - "application/json"
      parameters:
        - name: "palindrome"
          in: "path"
          description: "Text that may or may not be a palindrome"
          required: true
          type: "string"
      responses:
        "200":
          description: "OK"
        "404":
          description: "Palindrome entry does not exist"
    patch:
      summary: "Update an existing palindrome entry"
      description: "Replaces the text of the palindrome entry by the new text provided. If another entry already contains this text, the existing entry will be deleted and the existing entry will be returned."
      operationId: "updatePalindrome"
      consumes:
        - "application/json"
      produces:
        - "application/json"
      parameters:
        - name: "palindrome"
          in: "path"
          description: "Text that may or may not be a palindrome"
          required: true
          type: "string"
        - in: "body"
          name: "body"
          description: "Text to evaluate as palindrome or not"
          required: true
          schema:
            $ref: "#/definitions/Palindrome"
      responses:
        "200":
          description: "OK"
        "404":
          description: "Palindrome entry does not exist"
    delete:
      summary: "Delete an existing palindrome entry"
      consumes:
        - "application/json"
      produces:
        - "application/json"
      parameters:
        - name: "palindrome"
          in: "path"
          description: "Text that may or may not be a palindrome"
          required: true
          type: "string"
      responses:
        "200":
          description: "OK"
        "404":
          description: "Palindrome entry does not exist"
definitions:
  Palindrome:
    type: "object"
    properties:
      id:
        type: "integer"
      text:
        type: "string"
      is_palindrome:
        type: "boolean"
        default: false
    required:
      - text
    xml:
      name: "Palindrome"
