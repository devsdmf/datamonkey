# Annotations

All following annotations described here would be used in entity properties to mapping correctly your database schema:

* **@db_ref**: The database field that property represents
* **@pk**: Indicates that this property is a primary key in the table
* **@strategy**: Indicates the primary key strategy, should be *auto* for auto_increment primary keys, *manual* for 
primary keys that hasn't auto_increment, and *omitted* to keep the default (auto). 

For now, these are all available annotations, see the roadmap file at repository to see the future implementations.
