# GANSpace exploration

This documents assumes GANSpace has been installed on a Ubuntu 20.04 system.
More details on the installation can be found [here](SETUP.md).

## Table of contents
> - [Student info](#student-info)
> - [Used GAN](#used-gan)
> - [Interesting layers and components](#interesting-layers-and-components)

## Student info
- **Name**: Bontinck Lennert
- **StudentID**: 568702
- **Affiliation**: VUB - Master Computer Science: AI

## Used GAN
For this project a pre-trained model by NVIDIA for StyleGAN2 was used due to the performance boost it offers.
For this project the models of interest where those trained by NVIDIA on the [LSUN car dataset](https://www.yf.io/p/lsun).

The default implementation of GANSpace allows for easily using the *config f* variant of this model, which is also used for the project, by using the following command:

`python interactive.py --model=StyleGAN2 --class=car --layer=style -n=1_000_000 -b=10_000`

However, more pre-trained StyleGAN2 models are made available by NVIDIA on [google drive](https://drive.google.com/drive/folders/1yanUI9m4b4PWzR0eurKNq6JR1Bbfbh6L) and the [NVIDIA website](https://nvlabs-fi-cdn.nvidia.com/stylegan2/networks/). These pre-trained models can also be used in the tool by implementing their download in: `models/wrappers.py`.

The tool also allows for using your own StyleGAN, StyleGAN2 and BigGAN models. This has not been explored for this project.

## Interesting layers and components
Some of the more interesting layers and components are given here:

| Layer start | Layer end | Component | Title                  | Description                                                                                   |
|-------------|-----------|-----------|------------------------|-----------------------------------------------------------------------------------------------|
| 5           | 7         | 34        | Front and door molding | These settings seem to control the front of the car and the door moldings if the car has them |
| X           | Y         | Z         | XXX                    | YYY                                                                                           |
| X           | Y         | Z         | XXX                    | YYY                                                                                           |