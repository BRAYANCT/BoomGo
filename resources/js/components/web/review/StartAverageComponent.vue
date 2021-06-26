<template>
    <div class="row ">
        <div class="col-12">
            <ul class="list-unstyled list-inline rating m-0">
                <li v-for="(value , index) in stars" class="list-inline-item mr-1">
                    <i :class="getIconClass(value)+' amber-text'"></i>
                </li>
                <li class="list-inline-item">
                    <span class="text-muted">
                        {{ getTextClass() }}
                    </span>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        scoreAverageProp:  { default: '' },
        totalReviewsProp:  { default: '' },
        textTotalReviewsProp:  { default: '' },
    },
    data(){
        return {
            scoreAverage:this.scoreAverageProp,
            totalReviews:this.totalReviewsProp,
            textTotalReviews:this.textTotalReviewsProp,
            stars : [ 1, 2,3,4,5 ],
        }
    },
    mounted() {
        // console.log('Component Review Start average mounted.')
    },
    methods: {
        getTextClass: function () {
            if(this.totalReviews === ''){
                return this.scoreAverage;
            }

            let textTotalReviews = this.textTotalReviews;
            if(!fg.isEmpty(textTotalReviews)){
                textTotalReviews = " "+textTotalReviews;
            }
            return `${this.scoreAverage} (${this.totalReviews}${textTotalReviews})`;
        },
        getIconClass: function (start) {
            if(parseFloat(this.scoreAverage) >= parseFloat(start)){
                return ' fas fa-star ';
            }
            if(parseFloat(this.scoreAverage) >= parseFloat(start)-0.5 ){
                return ' fas fa-star-half-alt '
            }
            return 'far fa-star';
        },
    }
}
</script>
