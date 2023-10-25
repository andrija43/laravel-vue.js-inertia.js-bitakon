<template>
  <div class="marque__area">
    <div class="container">
      <div class="marque__inner p-relative">
        <div class="row">
          <div class="col-xxl-12">
            <div class="marque__wrapper">
              <div class="marque__slider" v-if="$page.props.primaryData">
                <div class="marque__item">
                  <p
                    v-for="(marquee, index) in $page.props.primaryData[
                      'marquee'
                    ].split(',')"
                  >
                    <span>{{ marquee }}</span>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
