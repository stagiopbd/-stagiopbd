FROM python:3-stretch AS builder

# Always set a working directory
WORKDIR /app
# Sets utf-8 encoding for Python et al
ENV LANG=C.UTF-8
# Turns off writing .pyc files; superfluous on an ephemeral container.
ENV PYTHONDONTWRITEBYTECODE=1
# Seems to speed things up
ENV PYTHONUNBUFFERED=1

# Ensures that the python and pip executables used
# in the image will be those from our virtualenv.
#ENV PATH="/venv/bin:$PATH"

# Install OS package dependencies.
# Do all of this in one RUN to limit final image size.
# RUN apt-get update && \
#     apt-get install -y --no-install-recommends \
#         gettext build-essential mariadb-client libmariadbclient-dev \
#         libxml2-dev libxslt1-dev libxslt1.1 && \
#     rm -rf /var/lib/apt/lists/*

# Setup the virtualenv
# RUN python -m venv /venv
# or "virtualenv /venv" for Python 2

# Install Python deps
COPY requirements.txt ./
RUN pip install --no-cache-dir -r requirements.txt

# CMD ["python3", "-m", "consumer"]
CMD ["python3", "Consumer.py"]