## Setup
1. Install anaconda or miniconda
2. Install git, then clone respository: `git clone https://github.com/harskish/ganspace/`
3. Create environment: `conda create -n ganspace python=3.7`
4. Activate environment: `conda activate ganspace`
   - EXTRA: `cd ganspace/`
5. Install dependencies: `conda env update -f environment.yml --prune`
6. Setup submodules: `git submodule update --init --recursive`
7. Run command `python -c "import nltk; nltk.download('wordnet')"`

### Interactive viewer
The interactive viewer (<i>interactive.py</i>) has the following dependencies:
- Glumpy
- PyCUDA with OpenGL support
- EXTRA: instructions for ubuntu 20.04 given below

#### Linux (ubuntu 20.04)
EXTRA: Activate environment: `conda activate ganspace`

1. Install CUDA toolkit (match the version in environment.yml)
   - EXTRA: Follow instructions from [here](https://medium.com/@stephengregory_69986/installing-cuda-10-1-on-ubuntu-20-04-e562a5e724a0)
   - EXTRA: `sudo apt install ctags`
   - EXTRA: `export CUDA_HOME=/usr/local/cuda-10.1`
2. Download pycuda sources from: https://pypi.org/project/pycuda/#files
3. Extract files: `tar -xzf pycuda-VERSION.tar.gz`
   - EXTRA: `cd pycuda-VERSION/`
4. Configure: `python configure.py --cuda-enable-gl --cuda-root=/path/to/cuda`
   - EXTRA: used this one instead `python configure.py --cuda-root=$CUDA_HOME --cuda-enable-gl`
5. Compile and install: `make install`
   - EXTRA: `sudo apt -y install gcc-8 g++-8`
   - EXTRA: `sudo update-alternatives --install /usr/bin/gcc gcc /usr/bin/gcc-8 8`
   - EXTRA: `sudo update-alternatives --install /usr/bin/g++ g++ /usr/bin/g++-8 8`
   - EXTRA: `pip install pytest`
   - EXTRA: `cd test/`
   - EXTRA: `python test_driver.py`
      - EXTRA: should all be green (and thus 100%)
6. Install Glumpy: `pip install setuptools cython glumpy`
   - EXTRA: before this pip install, install required package, namely: `pip install Cython`

### EXTRA: non installed pip dependencies
- `pip install colormap`
- `pip install easydev`
- `pip install pillow`
- `pip uninstall glumpy`
- `pip install glumpy`

### StyleGAN2 setup (optional)
StyleGAN2 contains custom CUDA kernels for improved performance.<br>
Less performant native PyTorch fallbacks are used by default.

EXTRA: go to root of ganspace

1. Install CUDA toolkit (match the version in environment.yml)
   - EXTRA: already done in previous step
   - EXTRA: error cublas_v2
3. `conda activate ganspace`
4. `cd models/stylegan2/stylegan2-pytorch/op`
5. `python setup.py install`
6. Test: `python -c "import torch; import upfirdn2d_op; import fused; print('OK')"`
