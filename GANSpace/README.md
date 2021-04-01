# Trying GANSpace on Ubuntu 20.04

Using GANSpace was not an easy task as the GANSpace tool and setup instructions from commit [65b0c4c](https://github.com/harskish/ganspace/tree/65b0c4c7a4bbdcb5fedebb7c033dab59e27d61c0) contained multiple issues when installing on Ubuntu 20.04.
An appropriate [SETUP.MD](clone/SETUP.md) was made to work with Ubuntu 20.04 and it was [committed to the issues page of the GANSpace repo](https://github.com/harskish/ganspace/issues/49).

## Table of contents
> - [Student info](#student-info)
> - [Used system](#used-system)
> - [GANSpace install](#ganspace-install)
> - [Edited parts](#edited-parts)
> - [Working with GANSpace](#working-with-ganspace)

## Student info
- **Name**: Bontinck Lennert
- **StudentID**: 568702
- **Affiliation**: VUB - Master Computer Science: AI

## Used system
Since StyleGAN is funded by NVIDIA, in order for StyleGAN and thus GANSpace to properly work, an NVIDIA graphics card is needed. 
A Linux distribution as OS is also recommended as Windows seems to give multiple issues and no MacOS alternative is available.
Ubuntu version 20.04 was used for this project and the installation is discussed in the [next section](#ganspace-install).

## GANSpace install

The clone folder consists of an edited copy of the GANSpace GitHub library, commit [65b0c4c7a4bbdcb5fedebb7c033dab59e27d61c0](https://github.com/harskish/ganspace/tree/65b0c4c7a4bbdcb5fedebb7c033dab59e27d61c0).

In the edited clone some extra files are given since the main GitHub repository contained some bugs with Ubuntu 20.04. These bugs have been resolved in this clone and an updated [SETUP.MD](clone/SETUP.md) is foreseen.

## Edited parts
- Included the used [Pycuda folder](clone/pycuda-2020.1/)
- Updated [SETUP.MD](SETUP.md)


## Working with GANSpace

For further details on how to work with GANSpace and reproduce visuals from the paper, [read this document](exploring_GANSpace.md).