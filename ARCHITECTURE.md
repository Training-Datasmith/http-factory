# Architecture: psr/http-factory (PSR-17)

## Purpose

This package defines PSR-17: HTTP Factories. It provides factory interfaces for
creating PSR-7 HTTP message objects (requests, responses, streams, URIs, and
uploaded files), enabling interoperability between PSR-7 implementations without
coupling to a specific library's constructors.

## PSR Standard

**PSR-17** — https://www.php-fig.org/psr/psr-17/

## Directory Structure

```
src/
  Request_Factory_Interface.php         — Creates outgoing client-side Request objects
  Response_Factory_Interface.php        — Creates server-side Response objects
  Server_Request_Factory_Interface.php  — Creates incoming server-side ServerRequest objects
  Stream_Factory_Interface.php          — Creates Stream objects from strings, files, resources
  Uploaded_File_Factory_Interface.php   — Creates UploadedFile value objects
  Uri_Factory_Interface.php             — Creates URI value objects from strings
```

## Key Design Decisions

### Why factories?
PSR-7 message objects are immutable value objects. Their concrete constructors
differ between implementations. Factories provide a stable, interface-level
way to instantiate them without knowing the concrete class — essential for
libraries that want to create messages independent of the underlying PSR-7 lib.

### One interface per message type
Each factory handles one PSR-7 type. This follows the Interface Segregation
Principle: a library that only needs to create responses need only depend on
`Response_Factory_Interface`, not on a monolithic factory.

### String URIs accepted everywhere
Methods that take a URI accept both `Uri_Interface` and `string`. This reduces
boilerplate for callers that already have a URI string and don't need to
construct a URI object manually.

### Server params are not parsed
`Server_Request_Factory_Interface::create_server_request()` stores `$server_params`
verbatim. Method and URI must be supplied explicitly; this prevents ambiguity
when adapting non-standard SAPI environments.

## Extension Points

- Implement any factory interface to support a new PSR-7 implementation.
- Use a combined factory class implementing multiple interfaces for convenience
  (e.g., one class implementing both Request and Response factories).

## Dependency Flow

```
Framework bootstrap / middleware
    └── *_Factory_Interface  (injected)
            └── PSR-7 value objects  (created on demand)
```
