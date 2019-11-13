# Pokémon Sword and Shield Data Dumps

This project parses the RAW data dumps from the Pokémon Sword and Shield games
into machine-readable format (optimized JSON).

All parsed data can be found under the `data/json` folder.

## Commands

**Parse**: Parses and exports all RAW data into JSON files: `./scripts/parse.php`

## The optimized `json` format

Since reading a whole JSON file in memory might be expensive, JSON files are
formatted in a way that each line represents a full JSON object in a list.

This way, you can read big files line by file, decoding each line from JSON to
an object.

The only thing your JSON parser needs to do is to skip the first and last lines
(which are `[\n` and `{}]\n` respectively) and trim the trailing comma `,` of each line.


## Credits

- Kurt / [@kwsch](https://github.com/kwsch) / [@Kaphotics](https://twitter.com/Kaphotics) for the data dumps 
