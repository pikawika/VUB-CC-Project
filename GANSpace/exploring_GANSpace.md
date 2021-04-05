# GANSpace exploration

This documents assumes GANSpace has been installed on a Ubuntu 20.04 system.
More details on the installation can be found [here](SETUP.md).

## Table of contents
> - [Student info](#student-info)
> - [Used GAN](#used-gan)
> - [Interesting layers and components](#interesting-layers-and-components)
> - [Interesting seeds](#interesting-seeds)

## Student info
- **Name**: Bontinck Lennert
- **StudentID**: 568702
- **Affiliation**: VUB - Master Computer Science: AI

## Used GAN
For this project a pre-trained model by NVIDIA for StyleGAN2 was used due to the performance boost it offers.
For this project the models of interest where those trained by NVIDIA on the [LSUN car dataset](https://www.yf.io/p/lsun).

The script rungan.sh will open the tool for the Stylegan2 LSUN *config f* model, which is also used for the project:

`./rungan.sh`

However, more pre-trained StyleGAN2 models are made available by NVIDIA on [google drive](https://drive.google.com/drive/folders/1yanUI9m4b4PWzR0eurKNq6JR1Bbfbh6L) and the [NVIDIA website](https://nvlabs-fi-cdn.nvidia.com/stylegan2/networks/). These pre-trained models can also be used in the tool by implementing their download in: `models/wrappers.py`.

The tool also allows for using your own StyleGAN, StyleGAN2 and BigGAN models. This has not been explored for this project.

## Interesting layers and components
Some of the more interesting layers and components are given here. If a component is used for a figure in the paper, it's specifically stated in the description.

| Layer start | Layer end | Component | Title                  | Description                                                                                   |
|-------------|-----------|-----------|------------------------|-----------------------------------------------------------------------------------------------|
| 5           | 7         | 34        | Front and door molding | These settings seem to control the front of the car and the door moldings if the car has them |
| 6           | 6         | 13         | Tire                    | This setting seems to influence the tire size                                                                                           |
| 8           | 8         | 0         | Rim                    | This setting influences the rim design without much collateral damage.                                                                                           |
| X           | X         | X         | X                    | X |
| X           | X         | X         | X                    | X |
| X           | X         | X         | X                    | X |
| X           | X         | X         | X                    | X |

## Interesting seeds
The following is a list of seeds which yield interesting or high quality generated images. If a seed is used for a figure in the paper, it's specifically stated in the description.

| Seed      | Title              | Description                          |
|-----------|--------------------|--------------------------------------|
| 533316386 | 50's car | Decent quality 50's car |
| 1468649076 | Front of old American | High quality front of old American looking car |
| 1550523335 | Ford Capri good background | Looks like a Ford Capri with detailed background |
| 2138738630 | SUV with different front | High quality SUV with front that looks tampered with |
| 412329070 | Side of saloon | High quality side of Saloon |
| 2037149942 | Long tailed BMW | Creative looking long tailed BMW |
| 1819530445 | Convertible pick-up truck  | Convertible pick-up truck with interesting artifact |
| 1279543286 | Warped commercial Chinese hatchback | A Chinese looking hatchback with good surroundings but warped design |
| 1814424239 | Interesting text artifact | Decent quality car with interesting text artifact |
| 1246138030 | Interesting car meet inspired | Bad quality but car meeting inspired |
| 20433421 | Hard edit American muscle | Decent quality but odd looking American muscle car |
| 1596739692 | Car melted through road | Interesting artifact where car looks melted through the road |
| 1562029704 | Side of squished 5 door | High quality image of squished side perspective |
| 869486137 | 208 Audi merge | Merge of Peugeot 2018 rear and Audi front |
| 1039508528 | Mustang station wagon | Merge of mustang with old school station wagon |
| 1436222308 | Nissan gtr r33 | Car with many resemblance to Nissan gtr r33 |
| 1318540350 | Front BMW Mercedes merge | Frontal image of Mercedes badged front with BMW styled headlights |
| 1822876201 | Off track and trailer artifact | Artifact where environment seems like a trailer and the off track section of a race track.  |
| 1391673713 | Realistic yet obviously fake | Creative image of clearly non existing car and background that does look "realistic". |
| 813273560 | Multi inspired car | High quality image of car that takes inspiration from multiple cars |
| 513749486 | Bentley omelette lights | Bentley inspired car with Porsche omelette lights |
| 324591731 | Album cover like | Unrecognizable image that gives the impression of an album cover |
| 1321501666 | Chevrolet with nice road scenery | Chevrolet inspired SUV with nice road scenery |
| 1708992259 | Toyota Corola inspired | Clearly Toyota Corola (old model) inspired car |
| 1950033031 | Porsche Aston Martin merge | Sports car that looks like a Porsche rear and and Aston Martin front |
| 2008785436 | Is the hood open | Interesting artifact where hood is slightly transparent and an open hood is visible |
| 1699790244 | Old school futuristic | Creative design of what would seem like a "futuristic" vision in the past |
| 1987292175 | Rear end or side | Artifact where the rear end of the car has become the side |
| 1955615330 | Attempt at reflection | High quality image of car with reflection in shiny floor |
| 000000000 | XXXxxxXXXXXXxxxXXX | YYYyyyYYYYYYyyyYYYYYYyyyYYYYYYyyyYYY |
| 000000000 | XXXxxxXXXXXXxxxXXX | YYYyyyYYYYYYyyyYYYYYYyyyYYYYYYyyyYYY |
| 000000000 | XXXxxxXXXXXXxxxXXX | YYYyyyYYYYYYyyyYYYYYYyyyYYYYYYyyyYYY |
| 000000000 | XXXxxxXXXXXXxxxXXX | YYYyyyYYYYYYyyyYYYYYYyyyYYYYYYyyyYYY |
| 000000000 | XXXxxxXXXXXXxxxXXX | YYYyyyYYYYYYyyyYYYYYYyyyYYYYYYyyyYYY |
| 1269338343 | No background car (1) | High quality image of car without background |
| 304896336 | No background car (2) | Decent quality image of car without background  |
| 807550690 | No background car (3) | High quality image of car without background |
| 665471536 | No background car (4) | Low quality image of car without background |
| 769809586 | No background car (5) | High quality Honda Civic inspired car without background |
| 1524176883 | No background car (6) | Decent quality Toyota Supra inspired car without background |
| 1384863398 | No background car (7) | High quality image of car without background |
| 823785839 | No background car (8) | High quality image of car without background |
| 1175008769 | No background car (9) | High quality image of car without background |
| 286807571 | No background car (10) | Decent quality image of car without background |
| 1102990066 | No background car (11) | Decent quality image of car without background |
| 80502057 | No background car (12) | Decent quality image of car without background |
| 000000000 | XXXxxxXXXXXXxxxXXX | YYYyyyYYYYYYyyyYYYYYYyyyYYYYYYyyyYYY |
| 000000000 | XXXxxxXXXXXXxxxXXX | YYYyyyYYYYYYyyyYYYYYYyyyYYYYYYyyyYYY |
| 000000000 | XXXxxxXXXXXXxxxXXX | YYYyyyYYYYYYyyyYYYYYYyyyYYYYYYyyyYYY |
| 000000000 | XXXxxxXXXXXXxxxXXX | YYYyyyYYYYYYyyyYYYYYYyyyYYYYYYyyyYYY |
| 000000000 | XXXxxxXXXXXXxxxXXX | YYYyyyYYYYYYyyyYYYYYYyyyYYYYYYyyyYYY |
| 853184016 | Challenging angle (1) | Challenging angle discussed in paper where AI can't seem to decide front of car  |
| 1963612912 | Challenging angle (2) | Challenging angle discussed in paper where AI can't seem to decide front of car  |
| 2022816787 | Challenging angle (3) | Challenging angle discussed in paper where AI can't seem to decide front of car |
| 1889987497 | Challenging angle (4) | Challenging angle discussed in paper where AI can't seem to decide front of car |
| 760138135 | Challenging angle (5) | Challenging angle discussed in paper where AI can't seem to decide front of car |
| 478583010 | Challenging angle (6) | Challenging angle discussed in paper where AI can't seem to decide front of car |

