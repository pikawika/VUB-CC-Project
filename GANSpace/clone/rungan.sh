source ~/anaconda3/etc/profile.d/conda.sh
conda activate ganspace
python interactive.py --model=StyleGAN2 --class=car --layer=style -n=1_000_000 -b=10_000